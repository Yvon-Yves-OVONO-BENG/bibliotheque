<?php

namespace App\Controller\StatutLivre;

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
#[Route('/statutLivre')]
class ImprimerUnStatutLivreController extends AbstractController
{
    #[Route('/imprimer-un-statut-livre', name: 'imprimer_un_statutLivre')]
    public function imprimerUnStatutLivre(): Response
    {
        return $this->render('statutLivre/index.html.twig', [
        ]);
    }
}
