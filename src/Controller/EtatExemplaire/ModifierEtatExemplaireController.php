<?php

namespace App\Controller\EtatExemplaire;

use DateTime;
use App\Services\StrService;
use App\Form\AjoutEtatExemplaireType;
use App\Repository\EtatExemplaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('/etatExemplaire')]
class ModifierEtatExemplaireController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected EtatExemplaireRepository $etatExemplaireRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/modifier-statut-emprunt/{slug}', name: 'modifier_etatExemplaire')]
    public function modifierEtatExemplaire(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $etatExemplaire = $this->etatExemplaireRepository->findOneBySlug(['slug' => $slug]);       
        
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
                ->setSupprime(0)
                ->setModifiePar($this->getUser())
                ->setModifieLeAt(new DateTime('now'))
                ;

                $this->em->persist($etatExemplaire);
                $this->em->flush(); 

                $this->addFlash('info', 'Etat exemplaire modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                return $this->redirectToRoute('liste_etatExemplaire', [
                    'm' => 1,
                ]);
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
            'etatExemplaire' => $etatExemplaire,
            'etatExemplaires' => $etatExemplaires,
            'csrfToken' => $csrfToken,
            'ajoutEtatExemplaireForm' => $form->createView(),
        ]);
    }
}
