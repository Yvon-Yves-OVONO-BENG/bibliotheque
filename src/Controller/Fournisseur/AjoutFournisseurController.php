<?php

namespace App\Controller\Fournisseur;

use App\Entity\Fournisseur;
use App\Form\AjoutFournisseurType;
use App\Repository\FournisseurRepository;
use App\Repository\UserRepository;
use App\Services\StrService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('/fournisseur')]
class AjoutFournisseurController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected FournisseurRepository $fournisseurRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/ajout-fournisseur', name: 'ajout_fournisseur')]
    public function ajoutFournisseur(Request $request): Response
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

        $fournisseur = new Fournisseur;       
        
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
            ->setSlug(uniqid('', true))
            ->setSupprime(0)
            ->setEnregistrePar($this->getUser())
            ->setEnregistreLeAt(new DateTime('now'))
            ;

            $this->em->persist($fournisseur);
            $this->em->flush(); 

            $this->addFlash('info', 'Fournisseur ajouté avec succès !');
            
            #j'affecte 1 à ma variable pour afficher le message
            $mySession->set('ajout', 1);

            $fournisseur = new Fournisseur();
            $form = $this->createForm(AjoutFournisseurType::class, $fournisseur);

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
            'csrfToken' => $csrfToken,
            'fournisseurs' => $fournisseurs,
            'ajoutFournisseurForm' => $form->createView(),
        ]);
    }
}
