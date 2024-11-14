<?php

namespace App\Controller\Fournisseur;

use DateTime;
use App\Repository\FournisseurRepository;
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
#[Route('/fournisseur')]
class SupprimerFournisseurController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected FournisseurRepository $fournisseurRepository
    ){}

    #[Route('/supprimer-fournisseur/{slug}', name: 'supprimer_fournisseur')]
    public function supprimerFournisseur(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $fournisseur = $this->fournisseurRepository->findOneBySlug(['slug' => $slug]);       
        
        $fournisseur->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($fournisseur);
        $this->em->flush(); 

        $this->addFlash('info', 'Fournisseur supprimmée avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_fournisseur', [
            's' => 1,
        ]);
            
        
    }
}
