<?php

namespace App\Controller\EtatPaiement;

use App\Entity\EtatPaiement;
use App\Form\AjoutEtatPaiementType;
use App\Repository\EtatPaiementRepository;
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
#[Route('/etatPaiement')]
class AjoutEtatPaiementController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected EtatPaiementRepository $etatPaiementRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/ajout-statut-emprunt', name: 'ajout_etatPaiement')]
    public function ajoutEtatPaiement(Request $request): Response
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

        $etatPaiement = new EtatPaiement;       
        
        $form = $this->createForm(AjoutEtatPaiementType::class, $etatPaiement);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireEtatPaiement')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireEtatPaiement', $csrfTokenFormulaire))) 
            {
                $etatPaiement->setEtatPaiement($this->strService->strToUpper($etatPaiement->getEtatPaiement()))
            ->setSlug(uniqid('', true))
            ->setSupprime(0)
            ->setEnregistrePar($this->getUser())
            ->setEnregistreLeAt(new DateTime('now'))
            ;

            $this->em->persist($etatPaiement);
            $this->em->flush(); 

            $this->addFlash('info', 'Etat paiement ajouté avec succès !');
            
            #j'affecte 1 à ma variable pour afficher le message
            $mySession->set('ajout', 1);

            $etatPaiement = new EtatPaiement();
            $form = $this->createForm(AjoutEtatPaiementType::class, $etatPaiement);

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

        #je récupère toutes mes etatPaiements non supprimées
        $etatPaiements = $this->etatPaiementRepository->findBy(['supprime' => 0]);

        return $this->render('etatPaiement/ajoutEtatPaiement.html.twig', [
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'etatPaiements' => $etatPaiements,
            'ajoutEtatPaiementForm' => $form->createView(),
        ]);
    }
}
