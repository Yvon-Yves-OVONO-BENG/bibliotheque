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
class ImprimerUnAuteurController extends AbstractController
{
    #[Route('/imprimer-un-auteur', name: 'imprimer_un_auteur')]
    public function imprimerUnAuteur(): Response
    {
        return $this->render('auteur/index.html.twig', [
        ]);
    }
}
