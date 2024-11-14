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
class ImprimerUnFournisseurController extends AbstractController
{
    #[Route('/imprimer-un-fournisseur', name: 'imprimer_un_fournisseur')]
    public function imprimerUnFournisseur(): Response
    {
        return $this->render('fournisseur/index.html.twig', [
        ]);
    }
}
