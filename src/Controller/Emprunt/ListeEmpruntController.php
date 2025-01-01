<?php

namespace App\Controller\Emprunt;

use App\Repository\EmpruntRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeEmpruntController extends AbstractController
{
    public function __construct(protected EmpruntRepository $empruntRepository)
    {
    }

    #[Route('/liste-emprunt', name: 'liste_emprunt')]
    public function listeEmprunt(Request $request): Response
    {
        $mySession = $request->getSession();
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);
        $emprunts = $this->empruntRepository->findBy([
            'supprime' => 0
        ]);
        return $this->render('emprunt/listeEmprunt.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }
}
