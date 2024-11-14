<?php

namespace App\Controller\Auteur;

use App\Entity\Auteur;
use App\Form\AjoutAuteurType;
use App\Repository\AuteurRepository;
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
#[Route('/auteur')]
class AjoutAuteurController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected AuteurRepository $auteurRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/ajout-auteur', name: 'ajout_auteur')]
    public function ajoutAuteur(Request $request): Response
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

        $auteur = new Auteur;       
        
        $form = $this->createForm(AjoutAuteurType::class, $auteur);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireAuteur')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireAuteur', $csrfTokenFormulaire))) 
            {
                $auteur->setNom($this->strService->strToUpper($auteur->getNom()))
            ->setSlug(uniqid('', true))
            ->setSupprime(0)
            ->setEnregistrePar($this->getUser())
            ->setEnregistreLeAt(new DateTime('now'))
            ;

            $this->em->persist($auteur);
            $this->em->flush(); 

            $this->addFlash('info', 'Auteur ajouté avec succès !');
            
            #j'affecte 1 à ma variable pour afficher le message
            $mySession->set('ajout', 1);

            $auteur = new Auteur();
            $form = $this->createForm(AjoutAuteurType::class, $auteur);

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

        #je récupère toutes mes auteurs non supprimées
        $auteurs = $this->auteurRepository->findBy(['supprime' => 0]);

        return $this->render('auteur/ajoutAuteur.html.twig', [
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'auteurs' => $auteurs,
            'ajoutAuteurForm' => $form->createView(),
        ]);
    }
}
