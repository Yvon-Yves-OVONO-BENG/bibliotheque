<?php

namespace App\Controller\GenreLitteraire;

use DateTime;
use App\Services\StrService;
use App\Form\AjoutGenreLitteraireType;
use App\Repository\GenreLitteraireRepository;
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
#[Route('/genreLitteraire')]
class ModifierGenreLitteraireController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected GenreLitteraireRepository $genreLitteraireRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/modifier-genre-litteraire/{slug}', name: 'modifier_genreLitteraire')]
    public function modifierGenreLitteraire(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $genreLitteraire = $this->genreLitteraireRepository->findOneBySlug(['slug' => $slug]);       
        
        $form = $this->createForm(AjoutGenreLitteraireType::class, $genreLitteraire);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireGenreLitteraire')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireGenreLitteraire', $csrfTokenFormulaire))) 
            {
                $genreLitteraire->setGenreLitteraire($this->strService->strToUpper($genreLitteraire->getGenreLitteraire()))
                ->setSupprime(0)
                ->setModifiePar($this->getUser())
                ->setModifieLeAt(new DateTime('now'))
                ;

                $this->em->persist($genreLitteraire);
                $this->em->flush(); 

                $this->addFlash('info', 'Genre Littéraire modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                return $this->redirectToRoute('liste_genreLitteraire', [
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

        #je récupère toutes mes genreLitteraires non supprimées
        $genreLitteraires = $this->genreLitteraireRepository->findBy(['supprime' => 0]);

        return $this->render('genreLitteraire/ajoutGenreLitteraire.html.twig', [
            'slug' => $slug,
            'genreLitteraire' => $genreLitteraire,
            'genreLitteraires' => $genreLitteraires,
            'csrfToken' => $csrfToken,
            'ajoutGenreLitteraireForm' => $form->createView(),
        ]);
    }
}
