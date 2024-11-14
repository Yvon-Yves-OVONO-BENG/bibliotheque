<?php

namespace App\Controller\StatutEmprunt;

use DateTime;
use App\Repository\StatutEmpruntRepository;
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
#[Route('/statutEmprunt')]
class SupprimerStatutEmpruntController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected StatutEmpruntRepository $statutEmpruntRepository
    ){}

    #[Route('/supprimer-statut-emprunt/{slug}', name: 'supprimer_statutEmprunt')]
    public function supprimerStatutEmprunt(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $statutEmprunt = $this->statutEmpruntRepository->findOneBySlug(['slug' => $slug]);       
        
        $statutEmprunt->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($statutEmprunt);
        $this->em->flush(); 

        $this->addFlash('info', 'Statut emprunt supprimmé avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_statutEmprunt', [
            's' => 1,
        ]);
            
        
    }
}
