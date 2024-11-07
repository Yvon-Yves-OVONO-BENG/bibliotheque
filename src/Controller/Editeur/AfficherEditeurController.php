<?php

namespace App\Controller\Editeur;

use App\Repository\EditeurRepository;
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
#[Route('/editeur')]
class AfficherEditeurController extends AbstractController
{
    public function __construct(
        protected EditeurRepository $editeurRepository
    )
    {}

    #[Route('/afficher-editeur/{slug}', name: 'afficher_editeur')]
    public function afficherEditeur(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'editeur à afficher
        $editeur = $this->editeurRepository->findOneBy(['slug' => $slug]);

        return $this->render('editeur/afficherEditeur.html.twig', [
            'editeur' => $editeur
        ]);
    }
}
