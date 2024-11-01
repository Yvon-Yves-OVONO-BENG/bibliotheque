<?php

namespace App\Controller\Auteur;

use DateTime;
use App\Repository\AuteurRepository;
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
class SupprimerAuteurController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected AuteurRepository $auteurRepository
    ){}

    #[Route('/supprimer-auteur/{slug}', name: 'supprimer_auteur')]
    public function supprimerAuteur(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $auteur = $this->auteurRepository->findOneBySlug(['slug' => $slug]);       
        
        $auteur->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($auteur);
        $this->em->flush(); 

        $this->addFlash('info', 'Auteur supprimmée avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_auteur', [
            's' => 1,
        ]);
            
        
    }
}
