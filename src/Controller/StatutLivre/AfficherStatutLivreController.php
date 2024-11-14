<?php

namespace App\Controller\StatutLivre;

use App\Repository\StatutLivreRepository;
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
#[Route('/statutLivre')]
class AfficherStatutLivreController extends AbstractController
{
    public function __construct(
        protected StatutLivreRepository $statutLivreRepository
    )
    {}

    #[Route('/afficher-statut-livre/{slug}', name: 'afficher_statutLivre')]
    public function afficherStatutLivre(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'statutLivre à afficher
        $statutLivre = $this->statutLivreRepository->findOneBy(['slug' => $slug]);

        return $this->render('statutLivre/afficherStatutLivre.html.twig', [
            'statutLivre' => $statutLivre
        ]);
    }
}
