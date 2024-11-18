<?php

namespace App\Controller\Exemplaire;


use App\Form\ExemplaireType;
use App\Repository\ExemplaireRepository;
use App\Services\StrService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Espace reservé uniquement aux administrateurs')]
class ModifierExemplaireController extends AbstractController
{
    public function __construct(
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected ExemplaireRepository $exemplaireRepository
        )
    { 
    }

    #[Route('/modifier-exemplaire/{slug}', name: 'modifier_exemplaire')]
    public function modifierExemplaire(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }
        
        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $exemplaire = $this->exemplaireRepository->findOneBy([
            'slug' => $slug
        ]); 
        
        $form = $this->createForm(ExemplaireType::class, $exemplaire);

        $form->handleRequest($request);
        
        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireExemplaire')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaireExemplaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireExemplaire', $csrfTokenFormulaireExemplaire))) 
            {
                $this->em->persist($exemplaire);
                $this->em->flush(); 
                $this->addFlash('info', 'Exemplaire modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                #je récupère tous les livres non supprimées
                $exemplaires = $this->exemplaireRepository->findBy(['supprime' => 0]);
                return $this->render('exemplaire/listeExemplaire.html.twig', [
                    'exemplaires' => $exemplaires,
                ]);
            } 
            else 
            {
                /**
                 * @var User
                 */
                $user = $this->getUser();
                $user->setBloque(1);
                return $this->redirectToRoute('app_logout');

            }
            
        }

        #je récupère tous les livres non supprimées pour afficher le nombre
        $exemplaires = $this->exemplaireRepository->findBy(['supprime' => 0]);
        
        return $this->render('exemplaire/ajoutExemplaire.html.twig', [
            'exemplaires' => $exemplaires,
            'exemplaire' => $exemplaire,
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'ajoutExemplaireForm' => $form->createView()
        ]);
    }
}
