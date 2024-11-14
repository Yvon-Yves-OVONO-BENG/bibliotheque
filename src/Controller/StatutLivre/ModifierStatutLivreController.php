<?php

namespace App\Controller\StatutLivre;

use DateTime;
use App\Services\StrService;
use App\Form\AjoutStatutLivreType;
use App\Repository\StatutLivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('/statutLivre')]
class ModifierStatutLivreController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected StatutLivreRepository $statutLivreRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/modifier-statut-livre/{slug}', name: 'modifier_statutLivre')]
    public function modifierStatutLivre(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $statutLivre = $this->statutLivreRepository->findOneBySlug(['slug' => $slug]);       
        
        $form = $this->createForm(AjoutStatutLivreType::class, $statutLivre);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireStatutLivre')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireStatutLivre', $csrfTokenFormulaire))) 
            {
                $statutLivre->setStatutLivre($this->strService->strToUpper($statutLivre->getStatutLivre()))
                ->setSupprime(0)
                ->setModifiePar($this->getUser())
                ->setModifieLeAt(new DateTime('now'))
                ;

                $this->em->persist($statutLivre);
                $this->em->flush(); 

                $this->addFlash('info', 'Statut livre modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                return $this->redirectToRoute('liste_statutLivre', [
                    'm' => 1,
                ]);
            }
            else 
            {
                /**
                 * @var User
                 */
                $user = $this->getUser();
                $user->setBloque(1);

                $this->em->persist($user);
                $this->em->flush();

                return $this->redirectToRoute('accueil', ['b' => 1 ]);

            }
            
        }

        #je récupère toutes mes statutLivres non supprimées
        $statutLivres = $this->statutLivreRepository->findBy(['supprime' => 0]);

        return $this->render('statutLivre/ajoutStatutLivre.html.twig', [
            'slug' => $slug,
            'statutLivre' => $statutLivre,
            'statutLivres' => $statutLivres,
            'csrfToken' => $csrfToken,
            'ajoutStatutLivreForm' => $form->createView(),
        ]);
    }
}
