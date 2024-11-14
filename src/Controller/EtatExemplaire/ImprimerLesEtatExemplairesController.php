<?php

namespace App\Controller\EtatExemplaire;

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
#[Route('/etatExemplaire')]
class ImprimerLesEtatExemplairesController extends AbstractController
{
    #[Route('/imprimer-les-statut-emprunts', name: 'imprimer_les_etatExemplaires')]
    public function imprimerLesEtatExemplaires(): Response
    {
        return $this->render('etatExemplaires/index.html.twig', [
            
        ]);
    }
}
