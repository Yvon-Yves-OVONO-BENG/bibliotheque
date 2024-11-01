<?php

namespace App\Controller\Armoire;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImprimerUneArmoireController extends AbstractController
{
    #[Route('/imprimer/une/armoire', name: 'app_imprimer_une_armoire')]
    public function index(): Response
    {
        return $this->render('imprimer_une_armoire/index.html.twig', [
            'controller_name' => 'ImprimerUneArmoireController',
        ]);
    }
}
