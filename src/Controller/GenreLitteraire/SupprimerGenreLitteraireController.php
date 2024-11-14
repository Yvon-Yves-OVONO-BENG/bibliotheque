<?php

namespace App\Controller\GenreLitteraire;

use DateTime;
use App\Repository\GenreLitteraireRepository;
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
#[Route('/genreLitteraire')]
class SupprimerGenreLitteraireController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected GenreLitteraireRepository $genreLitteraireRepository
    ){}

    #[Route('/supprimer-genre-litteraire/{slug}', name: 'supprimer_genreLitteraire')]
    public function supprimerGenreLitteraire(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $genreLitteraire = $this->genreLitteraireRepository->findOneBySlug(['slug' => $slug]);       
        
        $genreLitteraire->setSupprime(1)
        ->setSupprimePar($this->getUser())
        ->setSupprimeLeAt(new DateTime('now'))
        ;

        $this->em->persist($genreLitteraire);
        $this->em->flush(); 

        $this->addFlash('info', 'Genre Littéraire supprimmé avec succès !');
        
        #j'affecte 1 à ma variable pour afficher le message
        $mySession->set('suppression', 1);

        return $this->redirectToRoute('liste_genreLitteraire', [
            's' => 1,
        ]);
            
        
    }
}
