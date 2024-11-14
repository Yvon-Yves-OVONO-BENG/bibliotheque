<?php

namespace App\Controller\Fournisseur;

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
#[Route('/fournisseur')]
class ImprimerLesFournisseursController extends AbstractController
{
    #[Route('/imprimer-les-fournisseurs', name: 'imprimer_les_fournisseurs')]
    public function imprimerLesFournisseurs(): Response
    {
        return $this->render('fournisseurs/index.html.twig', [
            
        ]);
    }
}
