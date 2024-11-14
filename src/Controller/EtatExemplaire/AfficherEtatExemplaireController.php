<?php

namespace App\Controller\EtatExemplaire;

use App\Repository\EtatExemplaireRepository;
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
#[Route('/etatExemplaire')]
class AfficherEtatExemplaireController extends AbstractController
{
    public function __construct(
        protected EtatExemplaireRepository $etatExemplaireRepository
    )
    {}

    #[Route('/afficher-statut-emprunt/{slug}', name: 'afficher_etatExemplaire')]
    public function afficherEtatExemplaire(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'etatExemplaire à afficher
        $etatExemplaire = $this->etatExemplaireRepository->findOneBy(['slug' => $slug]);

        return $this->render('etatExemplaire/afficherEtatExemplaire.html.twig', [
            'etatExemplaire' => $etatExemplaire
        ]);
    }
}
