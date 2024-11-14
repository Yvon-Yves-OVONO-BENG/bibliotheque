<?php

namespace App\Controller\EtatReservation;

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
#[Route('/etatReservation')]
class ImprimerUnEtatReservationController extends AbstractController
{
    #[Route('/imprimer-un-statut-emprunt', name: 'imprimer_un_etatReservation')]
    public function imprimerUnEtatReservation(): Response
    {
        return $this->render('etatReservation/index.html.twig', [
        ]);
    }
}
