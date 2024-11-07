<?php

namespace App\Controller\Auteur;

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
#[Route('/auteur')]
class ImprimerLesAuteursController extends AbstractController
{
    #[Route('/imprimer-les-auteurs', name: 'imprimer_les_auteurs')]
    public function imprimerLesAuteurs(): Response
    {
        return $this->render('auteurs/index.html.twig', [
            
        ]);
    }
}
