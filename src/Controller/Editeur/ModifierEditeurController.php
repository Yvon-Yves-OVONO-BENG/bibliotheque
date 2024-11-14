<?php

namespace App\Controller\Editeur;

use DateTime;
use App\Services\StrService;
use App\Form\AjoutEditeurType;
use App\Repository\EditeurRepository;
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
#[Route('/editeur')]
class ModifierEditeurController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected EditeurRepository $editeurRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/modifier-editeur/{slug}', name: 'modifier_editeur')]
    public function modifierEditeur(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $editeur = $this->editeurRepository->findOneBySlug(['slug' => $slug]);       
        
        $form = $this->createForm(AjoutEditeurType::class, $editeur);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireEditeur')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireEditeur', $csrfTokenFormulaire))) 
            {
                $editeur->setEditeur($this->strService->strToUpper($editeur->getEditeur()))
                ->setSupprime(0)
                ->setModifiePar($this->getUser())
                ->setModifieLeAt(new DateTime('now'))
                ;

                $this->em->persist($editeur);
                $this->em->flush(); 

                $this->addFlash('info', 'Editeur modifiée avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                return $this->redirectToRoute('liste_editeur', [
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

        #je récupère toutes mes editeurs non supprimées
        $editeurs = $this->editeurRepository->findBy(['supprime' => 0]);

        return $this->render('editeur/ajoutEditeur.html.twig', [
            'slug' => $slug,
            'editeur' => $editeur,
            'editeurs' => $editeurs,
            'csrfToken' => $csrfToken,
            'ajoutEditeurForm' => $form->createView(),
        ]);
    }
}
