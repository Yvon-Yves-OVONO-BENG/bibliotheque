<?php

namespace App\Controller\EtatReservation;

use DateTime;
use App\Repository\EtatReservationRepository;
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
#[Route('/etatReservation')]
class SupprimerEtatReservationController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected EtatReservationRepository $etatReservationRepository
    ){}

    #[Route('/supprimer-etat-reservation/{slug}', name: 'supprimer_etatReservation')]
    public function supprimerEtatReservation(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $etatReservation = $this->etatReservationRepository->findOneBySlug(['slug' => $slug]);       
        
        $etatReservation->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($etatReservation);
        $this->em->flush(); 

        $this->addFlash('info', 'Etat réservation supprimmé avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_etatReservation', [
            's' => 1,
        ]);
            
        
    }
}
