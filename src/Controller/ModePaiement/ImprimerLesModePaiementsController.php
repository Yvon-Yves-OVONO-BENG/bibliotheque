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
class ImprimerLesModePaiementsController extends AbstractController
{
    #[Route('/imprimer-les-modePaiements', name: 'imprimer_les_modePaiements')]
    public function imprimerLesModePaiements(): Response
    {
        return $this->render('modePaiements/index.html.twig', [
            
        ]);
    }
}
