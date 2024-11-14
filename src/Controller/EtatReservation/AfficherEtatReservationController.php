<?php

namespace App\Controller\EtatReservation;

use App\Repository\EtatReservationRepository;
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
class AfficherEtatReservationController extends AbstractController
{
    public function __construct(
        protected EtatReservationRepository $etatReservationRepository
    )
    {}

    #[Route('/afficher-statut-emprunt/{slug}', name: 'afficher_etatReservation')]
    public function afficherEtatReservation(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'etatReservation à afficher
        $etatReservation = $this->etatReservationRepository->findOneBy(['slug' => $slug]);

        return $this->render('etatReservation/afficherEtatReservation.html.twig', [
            'etatReservation' => $etatReservation
        ]);
    }
}
