<?php

namespace App\Controller\Livre;

use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupprimerLivreController extends AbstractController
{
    public function __construct(protected LivreRepository $livreRepository, protected EntityManagerInterface $em)
    {
    }

    #[Route('/supprimer-livre/{slug}', name: 'supprimer_livre')]
    public function supprimerLivre(Request $request, string $slug): Response
    {
        //je récupère la session
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }
        $mySession->set('suppression', null);

        //Je recupère le livre à supprimer
        $livre = $this->livreRepository->findOneBy([
            'slug' => $slug
        ]);
        //Je vérifie s'il existe
        if ($livre) {
            //je le supprime des vues
            $livre->setSupprime(1);
            $this->em->persist($livre);
            $this->em->flush();
        }
        //Je récuppère la liste des livres non supprimés pour l'affichage après suppression
        $livres = $this->livreRepository->findOneBy([
            'supprime' => 0
        ]);
        //j'envoie une notification
        $this->addFlash('info', 'Livre supprimmé avec succès !');
        $mySession->set('suppression', 1);
        
        //Je fais le rendu du
        return $this->render('livre/listeLivre.html.twig', [
            'livres' => $livres,
        ]);
    }
}
