<?php

namespace App\Controller\GenreLitteraire;

use App\Repository\GenreLitteraireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('/genreLitteraire')]
class ListeGenreLitteraireController extends AbstractController
{
    public function __construct(
        protected GenreLitteraireRepository $genreLitteraireRepository
    )
    {}

    #[Route('/liste-genre-litteraire/{a<[0-1]{1}>}/{m<[0-1]{1}>}/{s<[0-1]{1}>}', name: 'liste_genreLitteraire')]
    public function listeGenreLitteraire(Request $request, int $a = 0, int $m = 0, int $s = 0): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();

        if ($a == 1 || $m == 0 || $s == 0) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', null);
            $maSession->set('suppression', null);
            
        }

        #je teste si le témoin n'est pas vide pour savoir s'il vient de la mise à jour
        if ($m == 1) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', 1);
            $maSession->set('suppression', null);
            
        }

        #je teste si le témoin n'est pas vide pour savoir s'il vient de la suppression
        
        if ($s == 1) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', null);
            $maSession->set('suppression', 1);
            
        }

        #je récupère toutes mes genreLitteraires non supprimées
        $genreLitteraires = $this->genreLitteraireRepository->findBy (['supprime' => 0]);
        
        return $this->render('genreLitteraire/listeGenreLitteraire.html.twig', [
            'genreLitteraires' => $genreLitteraires,
        ]);
    }
}
