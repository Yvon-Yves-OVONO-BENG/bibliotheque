<?php

namespace App\Controller\Armoire;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImprimerLesArmoiresController extends AbstractController
{
    #[Route('/imprimer/les/armoires', name: 'app_imprimer_les_armoires')]
    public function index(): Response
    {
        return $this->render('imprimer_les_armoires/index.html.twig', [
            'controller_name' => 'ImprimerLesArmoiresController',
        ]);
    }
}
