<?php

use App\Repository\LivreRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Espace reservé uniquement aux administrateurs')]
class MontantLivreController extends AbstractController
{
    #[Route('/montant-livre/{id}', name: 'montant_livre', methods: ['GET'])]
    public function getMontantLivre($id, LivreRepository $livreRepository): JsonResponse
    {
        $livre = $livreRepository->find($id);

        if (!$livre) {
            return new JsonResponse(['error' => 'Livre non trouvé'], 404);
        }
        
        return new JsonResponse(['montant' => $livre->getMontantEmprunt()]);
    }
}