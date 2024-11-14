<?php

namespace App\Controller\Fournisseur;

use App\Repository\FournisseurRepository;
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
#[Route('/fournisseur')]
class AfficherFournisseurController extends AbstractController
{
    public function __construct(
        protected FournisseurRepository $fournisseurRepository
    )
    {}

    #[Route('/afficher-fournisseur/{slug}', name: 'afficher_fournisseur')]
    public function afficherFournisseur(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'fournisseur à afficher
        $fournisseur = $this->fournisseurRepository->findOneBy(['slug' => $slug]);

        return $this->render('fournisseur/afficherFournisseur.html.twig', [
            'fournisseur' => $fournisseur
        ]);
    }
}
