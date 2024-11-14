<?php

namespace App\Controller\Auteur;

use App\Repository\AuteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('/auteur')]
class AfficherAuteurController extends AbstractController
{
    public function __construct(
        protected AuteurRepository $auteurRepository
    )
    {}

    #[Route('/afficher-auteur/{slug}', name: 'afficher_auteur')]
    public function afficherAuteur(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'auteur à afficher
        $auteur = $this->auteurRepository->findOneBy(['slug' => $slug]);

        return $this->render('auteur/afficherAuteur.html.twig', [
            'auteur' => $auteur
        ]);
    }
}
