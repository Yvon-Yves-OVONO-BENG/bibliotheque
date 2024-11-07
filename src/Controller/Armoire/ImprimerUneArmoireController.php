<?php

namespace App\Controller\Armoire;

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
#[Route('/armoire')]
class ImprimerUneArmoireController extends AbstractController
{
    #[Route('/imprimer-une-armoire', name: 'imprimer_une_armoire')]
    public function imprimerUneArmoire(): Response
    {
        return $this->render('armoire/index.html.twig', [
        ]);
    }
}
