<?php

namespace App\Controller\GenreLitteraire;

use App\Repository\GenreLitteraireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/genreLitteraire')]
class AfficherGenreLitteraireController extends AbstractController
{
    public function __construct(
        protected GenreLitteraireRepository $genreLitteraireRepository
    )
    {}

    #[Route('/afficher-genre-litteraire/{a<[0-1]{1}>}/{m<[0-1]{1}>}/{s<[0-1]{1}>}', name: 'afficher_genreLitteraire')]
    public function afficherGenreLitteraire(Request $request, int $a = 0, int $m = 0, int $s = 0): Response
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
        
        return $this->render('genreLitteraire/afficherGenreLitteraire.html.twig', [
            'genreLitteraires' => $genreLitteraires,
        ]);
    }
}
