<?php

namespace App\Controller\Emprunt;

use App\Repository\EmpruntRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupprimerEmpruntController extends AbstractController
{
    public function __construct(protected EmpruntRepository $empruntRepository, protected EntityManagerInterface $em)
    {
    }

    #[Route('/supprimer-emprunt/{slug}', name: 'supprimer_emprunt')]
    public function supprimerEmprunt(Request $request, string $slug): Response
    {
        //je récupère la session
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }
        $mySession->set('suppression', null);

        //Je recupère le emprunt à supprimer
        $emprunt = $this->empruntRepository->findOneBy([
            'slug' => $slug
        ]);
        //Je vérifie s'il existe
        if ($emprunt) {
            //je le supprime des vues
            $emprunt->setSupprime(1)
                ->setSupprimePar($this->getUser())
                ->setSupprimeLeAt(new DateTime('now'));
            $this->em->persist($emprunt);
            $this->em->flush();
        }
        //Je récuppère la liste des emprunts non supprimés pour l'affichage après suppression
        $emprunts = $this->empruntRepository->findOneBy([
            'supprime' => 0
        ]);
        //j'envoie une notification
        $this->addFlash('info', 'Emprunt supprimmé avec succès !');
        $mySession->set('suppression', 1);
        
        //Je fais le rendu du
        return $this->render('emprunt/listeEmprunt.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }
}
