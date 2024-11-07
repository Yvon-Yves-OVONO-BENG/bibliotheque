<?php

namespace App\Controller\ModePaiement;

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
#[Route('/modePaiement')]
class ImprimerUnModePaiementController extends AbstractController
{
    #[Route('/imprimer-un-modePaiement', name: 'imprimer_un_modePaiement')]
    public function imprimerUnModePaiement(): Response
    {
        return $this->render('modePaiement/index.html.twig', [
        ]);
    }
}
