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
class ImprimerLesStatutLivresController extends AbstractController
{
    #[Route('/imprimer-les-statut-livres', name: 'imprimer_les_statutLivres')]
    public function imprimerLesStatutLivres(): Response
    {
        return $this->render('statutLivres/index.html.twig', [
            
        ]);
    }
}
