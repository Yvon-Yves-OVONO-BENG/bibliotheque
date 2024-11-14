<?php

namespace App\Controller\StatutEmprunt;

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
#[Route('/statutEmprunt')]
class ImprimerLesStatutEmpruntsController extends AbstractController
{
    #[Route('/imprimer-les-statut-emprunts', name: 'imprimer_les_statutEmprunts')]
    public function imprimerLesStatutEmprunts(): Response
    {
        return $this->render('statutEmprunts/index.html.twig', [
            
        ]);
    }
}
