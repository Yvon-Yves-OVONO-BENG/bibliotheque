<?php

namespace App\Controller\EtatReservation;

use DateTime;
use App\Services\StrService;
use App\Form\AjoutEtatReservationType;
use App\Repository\EtatReservationRepository;
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
#[Route('/etatReservation')]
class ModifierEtatReservationController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected EtatReservationRepository $etatReservationRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/modifier-statut-emprunt/{slug}', name: 'modifier_etatReservation')]
    public function modifierEtatReservation(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $etatReservation = $this->etatReservationRepository->findOneBySlug(['slug' => $slug]);       
        
        $form = $this->createForm(AjoutEtatReservationType::class, $etatReservation);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireEtatReservation')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireEtatReservation', $csrfTokenFormulaire))) 
            {
                $etatReservation->setEtatReservation($this->strService->strToUpper($etatReservation->getEtatReservation()))
                ->setSupprime(0)
                ->setModifiePar($this->getUser())
                ->setModifieLeAt(new DateTime('now'))
                ;

                $this->em->persist($etatReservation);
                $this->em->flush(); 

                $this->addFlash('info', 'Etat réservation modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                return $this->redirectToRoute('liste_etatReservation', [
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

        #je récupère toutes mes etatReservations non supprimées
        $etatReservations = $this->etatReservationRepository->findBy(['supprime' => 0]);

        return $this->render('etatReservation/ajoutEtatReservation.html.twig', [
            'slug' => $slug,
            'etatReservation' => $etatReservation,
            'etatReservations' => $etatReservations,
            'csrfToken' => $csrfToken,
            'ajoutEtatReservationForm' => $form->createView(),
        ]);
    }
}
