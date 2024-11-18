<?php

namespace App\Controller\Exemplaire;

use App\Entity\Exemplaire;
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
class AjoutExemplaireController extends AbstractController
{
    public function __construct(
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected ExemplaireRepository $exemplaireRepository

        )
    { 
    }

    #[Route('/ajout-exemplaire', name: 'ajout_exemplaire')]
    public function ajoutexemplaire(Request $request): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }
        

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);
        $slug = "";

        $exemplaire = new Exemplaire();

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
                $exemplaire->setSlug(md5(uniqid()))
                            ->setSupprime(0);
                $this->em->persist($exemplaire);
                $this->em->flush(); 
                $this->addFlash('info', 'Exemplaire ajouté avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('ajout', 1);

                $exemplaire = new Exemplaire();
                $form = $this->createForm(ExemplaireType::class, $exemplaire);

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
        #je récupère tous les livres non supprimées
        $exemplaires = $this->exemplaireRepository->findBy(['supprime' => 0]);

        return $this->render('exemplaire/ajoutExemplaire.html.twig', [
            'exemplaires' => $exemplaires,
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'ajoutExemplaireForm' => $form->createView()
        ]);
    }
}
