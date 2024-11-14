<?php

namespace App\Controller\EtatPaiement;

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
#[Route('/etatPaiement')]
class ImprimerLesEtatPaiementsController extends AbstractController
{
    #[Route('/imprimer-les-statut-emprunts', name: 'imprimer_les_etatPaiements')]
    public function imprimerLesEtatPaiements(): Response
    {
        return $this->render('etatPaiements/index.html.twig', [
            
        ]);
    }
}
