<?php

namespace App\Controller\Exemplaire;

use App\Repository\ExemplaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeExemplaireController extends AbstractController
{
    public function __construct( 
        protected ExemplaireRepository $exemplaireRepository
        )
    {
    }

    #[Route('/liste-exemplaire', name: 'liste_exemplaire')]
    public function listeExemplaire(Request $request): Response
    {
        $mySession = $request->getSession();
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);
        $exemplaires = $this->exemplaireRepository->findBy([
            'supprime' => 0
        ]);
        return $this->render('exemplaire/listeExemplaire.html.twig', [
            'exemplaires' => $exemplaires,
        ]);
    }
}
