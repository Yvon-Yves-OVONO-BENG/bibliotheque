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
class ImprimerLesArmoiresController extends AbstractController
{
    #[Route('/imprimer-les-armoires', name: 'imprimer_les_armoires')]
    public function imprimerLesArmoires(): Response
    {
        return $this->render('armoires/index.html.twig', [
            
        ]);
    }
}
