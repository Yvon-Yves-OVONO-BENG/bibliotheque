<?php

namespace App\Controller\Exemplaire;

use App\Repository\ExemplaireRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupprimerExemplaireController extends AbstractController
{
    public function __construct( 
        protected EntityManagerInterface $em,
        protected ExemplaireRepository $exemplaireRepository
        )
    {
    }

    #[Route('/supprimer-exemplaire/{slug}', name: 'supprimer_exemplaire')]
    public function supprimerExemplaire(Request $request, string $slug): Response
    {
        //je récupère la session
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }
        $mySession->set('suppression', null);

        //Je recupère le livre à supprimer
        $exemplaire = $this->exemplaireRepository->findOneBy([
            'slug' => $slug
        ]);
        //Je vérifie s'il existe
        if ($exemplaire) {
            //je le supprime des vues
            $exemplaire->setSupprime(1)
                ->setSupprimePar($this->getUser())
                ->setSupprimeLeAt(new DateTime('now'));
            $this->em->persist($exemplaire);
            $this->em->flush();
        }
        //Je récuppère la liste des livres non supprimés pour l'affichage après suppression
        $exemplaires = $this->exemplaireRepository->findOneBy([
            'supprime' => 0
        ]);
        //j'envoie une notification
        $this->addFlash('info', 'Exemplaire supprimmé avec succès !');
        $mySession->set('suppression', 1);
        
        //Je fais le rendu du
        return $this->render('exemplaire/listeExemplaire.html.twig', [
            'exemplaires' => $exemplaires,
        ]);
    }
}
