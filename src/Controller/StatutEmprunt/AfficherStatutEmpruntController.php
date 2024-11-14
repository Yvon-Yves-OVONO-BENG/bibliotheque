<?php

namespace App\Controller\StatutEmprunt;

use App\Repository\StatutEmpruntRepository;
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
#[Route('/statutEmprunt')]
class AfficherStatutEmpruntController extends AbstractController
{
    public function __construct(
        protected StatutEmpruntRepository $statutEmpruntRepository
    )
    {}

    #[Route('/afficher-statut-emprunt/{slug}', name: 'afficher_statutEmprunt')]
    public function afficherStatutEmprunt(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'statutEmprunt à afficher
        $statutEmprunt = $this->statutEmpruntRepository->findOneBy(['slug' => $slug]);

        return $this->render('statutEmprunt/afficherStatutEmprunt.html.twig', [
            'statutEmprunt' => $statutEmprunt
        ]);
    }
}
