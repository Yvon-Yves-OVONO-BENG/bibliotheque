<?php

namespace App\Controller\EtatPaiement;

use DateTime;
use App\Repository\EtatPaiementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('/etatPaiement')]
class SupprimerEtatPaiementController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected EtatPaiementRepository $etatPaiementRepository
    ){}

    #[Route('/supprimer-etat-paiement/{slug}', name: 'supprimer_etatPaiement')]
    public function supprimerEtatPaiement(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $etatPaiement = $this->etatPaiementRepository->findOneBySlug(['slug' => $slug]);       
        
        $etatPaiement->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($etatPaiement);
        $this->em->flush(); 

        $this->addFlash('info', 'Etat paiement supprimmé avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_etatPaiement', [
            's' => 1,
        ]);
            
        
    }
}
