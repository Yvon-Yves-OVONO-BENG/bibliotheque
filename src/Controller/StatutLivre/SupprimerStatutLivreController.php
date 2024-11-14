<?php

namespace App\Controller\StatutLivre;

use DateTime;
use App\Repository\StatutLivreRepository;
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
#[Route('/statutLivre')]
class SupprimerStatutLivreController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected StatutLivreRepository $statutLivreRepository
    ){}

    #[Route('/supprimer-statut-livre/{slug}', name: 'supprimer_statutLivre')]
    public function supprimerStatutLivre(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $statutLivre = $this->statutLivreRepository->findOneBySlug(['slug' => $slug]);       
        
        $statutLivre->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($statutLivre);
        $this->em->flush(); 

        $this->addFlash('info', 'Statut livre supprimmé avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_statutLivre', [
            's' => 1,
        ]);
            
        
    }
}
