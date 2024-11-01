<?php

namespace App\Controller\Armoire;

use DateTime;
use App\Repository\ArmoireRepository;
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
class SupprimerArmoireController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected ArmoireRepository $armoireRepository
    ){}

    #[Route('/supprimer-armoire/{slug}', name: 'supprimer_armoire')]
    public function supprimerArmoire(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $armoire = $this->armoireRepository->findOneBySlug(['slug' => $slug]);       
        
        $armoire->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($armoire);
        $this->em->flush(); 

        $this->addFlash('info', 'Armoire supprimmée avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_armoire', [
            's' => 1,
        ]);
            
        
    }
}
