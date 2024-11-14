<?php

namespace App\Controller\EtatExemplaire;

use DateTime;
use App\Repository\EtatExemplaireRepository;
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
#[Route('/etatExemplaire')]
class SupprimerEtatExemplaireController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected EtatExemplaireRepository $etatExemplaireRepository
    ){}

    #[Route('/supprimer-etat-exemplaire/{slug}', name: 'supprimer_etatExemplaire')]
    public function supprimerEtatExemplaire(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $etatExemplaire = $this->etatExemplaireRepository->findOneBySlug(['slug' => $slug]);       
        
        $etatExemplaire->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($etatExemplaire);
        $this->em->flush(); 

        $this->addFlash('info', 'Etat exemplaire supprimmé avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_etatExemplaire', [
            's' => 1,
        ]);
            
        
    }
}
