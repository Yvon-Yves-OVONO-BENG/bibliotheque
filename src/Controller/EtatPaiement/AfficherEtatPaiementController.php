<?php

namespace App\Controller\EtatPaiement;

use App\Repository\EtatPaiementRepository;
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
#[Route('/etatPaiement')]
class AfficherEtatPaiementController extends AbstractController
{
    public function __construct(
        protected EtatPaiementRepository $etatPaiementRepository
    )
    {}

    #[Route('/afficher-statut-emprunt/{slug}', name: 'afficher_etatPaiement')]
    public function afficherEtatPaiement(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        #je récupère l'etatPaiement à afficher
        $etatPaiement = $this->etatPaiementRepository->findOneBy(['slug' => $slug]);

        return $this->render('etatPaiement/afficherEtatPaiement.html.twig', [
            'etatPaiement' => $etatPaiement
        ]);
    }
}
