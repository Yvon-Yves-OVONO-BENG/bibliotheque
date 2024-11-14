<?php

namespace App\Controller\Editeur;

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
#[Route('/editeur')]
class ImprimerLesEditeursController extends AbstractController
{
    #[Route('/imprimer-les-editeurs', name: 'imprimer_les_editeurs')]
    public function imprimerLesEditeurs(): Response
    {
        return $this->render('editeurs/index.html.twig', [
            
        ]);
    }
}
