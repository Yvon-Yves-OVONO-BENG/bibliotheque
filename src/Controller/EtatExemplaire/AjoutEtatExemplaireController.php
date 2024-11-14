<?php

namespace App\Controller\EtatExemplaire;

use App\Entity\EtatExemplaire;
use App\Form\AjoutEtatExemplaireType;
use App\Repository\EtatExemplaireRepository;
use App\Repository\UserRepository;
use App\Services\StrService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('/etatExemplaire')]
class AjoutEtatExemplaireController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected EtatExemplaireRepository $etatExemplaireRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/ajout-statut-emprunt', name: 'ajout_etatExemplaire')]
    public function ajoutEtatExemplaire(Request $request): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);
        
        $slug = "";

        $etatExemplaire = new EtatExemplaire;       
        
        $form = $this->createForm(AjoutEtatExemplaireType::class, $etatExemplaire);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireEtatExemplaire')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireEtatExemplaire', $csrfTokenFormulaire))) 
            {
                $etatExemplaire->setEtatExemplaire($this->strService->strToUpper($etatExemplaire->getEtatExemplaire()))
            ->setSlug(uniqid('', true))
            ->setSupprime(0)
            ->setEnregistrePar($this->getUser())
            ->setEnregistreLeAt(new DateTime('now'))
            ;

            $this->em->persist($etatExemplaire);
            $this->em->flush(); 

            $this->addFlash('info', 'Etat exemplaire ajouté avec succès !');
            
            #j'affecte 1 à ma variable pour afficher le message
            $mySession->set('ajout', 1);

            $etatExemplaire = new EtatExemplaire();
            $form = $this->createForm(AjoutEtatExemplaireType::class, $etatExemplaire);

            } 
            else 
            {
                /**
                 * @var User
                 */
                $user = $this->getUser();
                $user->setBloque(1);

                $this->em->persist($user);
                $this->em->flush();

                return $this->redirectToRoute('accueil', ['b' => 1 ]);

            }
            
        }

        #je récupère toutes mes etatExemplaires non supprimées
        $etatExemplaires = $this->etatExemplaireRepository->findBy(['supprime' => 0]);

        return $this->render('etatExemplaire/ajoutEtatExemplaire.html.twig', [
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'etatExemplaires' => $etatExemplaires,
            'ajoutEtatExemplaireForm' => $form->createView(),
        ]);
    }
}
