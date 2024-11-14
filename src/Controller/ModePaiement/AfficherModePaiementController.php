<?php

namespace App\Controller\ModePaiement;

use App\Repository\ModePaiementRepository;
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
#[Route('/modePaiement')]
class AfficherModePaiementController extends AbstractController
{
    public function __construct(
        protected ModePaiementRepository $modePaiementRepository
    )
    {}

    #[Route('/afficher-modePaiement/{slug}', name: 'afficher_modePaiement')]
    public function afficherModePaiement(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'modePaiement à afficher
        $modePaiement = $this->modePaiementRepository->findOneBy(['slug' => $slug]);

        return $this->render('modePaiement/afficherModePaiement.html.twig', [
            'modePaiement' => $modePaiement
        ]);
    }
}
