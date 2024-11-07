<?php

namespace App\Controller\Editeur;

use DateTime;
use App\Repository\EditeurRepository;
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
#[Route('/editeur')]
class SupprimerEditeurController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected EditeurRepository $editeurRepository
    ){}

    #[Route('/supprimer-editeur/{slug}', name: 'supprimer_editeur')]
    public function supprimerEditeur(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $editeur = $this->editeurRepository->findOneBySlug(['slug' => $slug]);       
        
        $editeur->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($editeur);
        $this->em->flush(); 

        $this->addFlash('info', 'Editeur supprimmée avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_editeur', [
            's' => 1,
        ]);
            
        
    }
}
