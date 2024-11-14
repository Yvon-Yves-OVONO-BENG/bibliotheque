<?php

namespace App\Controller\GenreLitteraire;

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
#[Route('/genreLitteraire')]
class ImprimerUnGenreLitteraireController extends AbstractController
{
    #[Route('/imprimer-un-genre-litteraire', name: 'imprimer_un_genreLitteraire')]
    public function imprimerUnGenreLitteraire(): Response
    {
        return $this->render('genreLitteraire/index.html.twig', [
        ]);
    }
}
