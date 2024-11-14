<?php

namespace App\Controller\GenreLitteraire;

use App\Repository\GenreLitteraireRepository;
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
#[Route('/genreLitteraire')]
class DetailsGenreLitteraireController extends AbstractController
{
    public function __construct(
        protected GenreLitteraireRepository $genreLitteraireRepository
    )
    {}

    #[Route('/details-genre-litteraire/{slug}', name: 'details_genreLitteraire')]
    public function detailsGenreLitteraire(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'genreLitteraire à details
        $genreLitteraire = $this->genreLitteraireRepository->findOneBy(['slug' => $slug]);

        return $this->render('genreLitteraire/detailsGenreLitteraire.html.twig', [
            'genreLitteraire' => $genreLitteraire
        ]);
    }
}
