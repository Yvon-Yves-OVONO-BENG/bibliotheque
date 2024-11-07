<?php

namespace App\Controller\ModePaiement;

use DateTime;
use App\Repository\ModePaiementRepository;
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
#[Route('/modePaiement')]
class SupprimerModePaiementController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected ModePaiementRepository $modePaiementRepository
    ){}

    #[Route('/supprimer-modePaiement/{slug}', name: 'supprimer_modePaiement')]
    public function supprimerModePaiement(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $modePaiement = $this->modePaiementRepository->findOneBySlug(['slug' => $slug]);       
        
        $modePaiement->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($modePaiement);
        $this->em->flush(); 

        $this->addFlash('info', 'ModePaiement supprimmée avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_modePaiement', [
            's' => 1,
        ]);
            
        
    }
}
