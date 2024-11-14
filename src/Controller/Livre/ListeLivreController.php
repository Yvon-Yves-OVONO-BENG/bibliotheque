<?php

namespace App\Controller\Livre;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeLivreController extends AbstractController
{
    public function __construct(protected LivreRepository $livreRepository)
    {
    }

    #[Route('/liste-livre', name: 'liste_livre')]
    public function listeLivre(Request $request): Response
    {
        $mySession = $request->getSession();
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);
        $livres = $this->livreRepository->findBy([
            'supprime' => 0
        ]);
        return $this->render('livre/listeLivre.html.twig', [
            'livres' => $livres,
        ]);
    }
}
