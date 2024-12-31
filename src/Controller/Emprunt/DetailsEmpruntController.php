<?php

namespace App\Controller\Emprunt;

use App\Repository\EmpruntRepository;
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
#[Route('/emprunt')]
class DetailsEmpruntController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected EmpruntRepository $empruntRepository,  
        )
    {}

    #[Route('/details-emprunt/{slug}/{m<[0-1]{1}>}', name: 'details_emprunt')]
    public function detailsEmprunt(Request $request, $slug, $m = 0): Response
    {
        #je teste si le témoin n'est pas vide pour savoir s'il vient de la mise à jour
        if ($m == 1) 
        {
            # je récupère ma session
            $maSession = $request->getSession();
            
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', 1);
            $maSession->set('suppression', null);
            
        }

        $emprunt = $this->empruntRepository->findOneBySlug([
            'slug' => $slug
        ]);

        return $this->render('emprunt/detailsEmprunt.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }
}
