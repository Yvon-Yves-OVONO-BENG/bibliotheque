<?php

namespace App\Controller\Fournisseur;

use DateTime;
use App\Services\StrService;
use App\Form\AjoutFournisseurType;
use App\Repository\FournisseurRepository;
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
#[Route('/fournisseur')]
class ModifierFournisseurController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected FournisseurRepository $fournisseurRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/modifier-fournisseur/{slug}', name: 'modifier_fournisseur')]
    public function modifierFournisseur(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $fournisseur = $this->fournisseurRepository->findOneBySlug(['slug' => $slug]);       
        
        $form = $this->createForm(AjoutFournisseurType::class, $fournisseur);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireFournisseur')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireFournisseur', $csrfTokenFormulaire))) 
            {
                $fournisseur->setNom($this->strService->strToUpper($fournisseur->getNom()))
                ->setSupprime(0)
                ->setModifiePar($this->getUser())
                ->setModifieLeAt(new DateTime('now'))
                ;

                $this->em->persist($fournisseur);
                $this->em->flush(); 

                $this->addFlash('info', 'Fournisseur modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                return $this->redirectToRoute('liste_fournisseur', [
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

        #je récupère toutes mes fournisseurs non supprimées
        $fournisseurs = $this->fournisseurRepository->findBy(['supprime' => 0]);

        return $this->render('fournisseur/ajoutFournisseur.html.twig', [
            'slug' => $slug,
            'fournisseur' => $fournisseur,
            'fournisseurs' => $fournisseurs,
            'csrfToken' => $csrfToken,
            'ajoutFournisseurForm' => $form->createView(),
        ]);
    }
}
