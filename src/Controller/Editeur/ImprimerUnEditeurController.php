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
class ImprimerUnEditeurController extends AbstractController
{
    #[Route('/imprimer-un-editeur', name: 'imprimer_un_editeur')]
    public function imprimerUnEditeur(): Response
    {
        return $this->render('editeur/index.html.twig', [
        ]);
    }
}
