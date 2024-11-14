<?php

namespace App\Controller\EtatPaiement;

use DateTime;
use App\Services\StrService;
use App\Form\AjoutEtatPaiementType;
use App\Repository\EtatPaiementRepository;
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
#[Route('/etatPaiement')]
class ModifierEtatPaiementController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected EtatPaiementRepository $etatPaiementRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/modifier-statut-emprunt/{slug}', name: 'modifier_etatPaiement')]
    public function modifierEtatPaiement(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $etatPaiement = $this->etatPaiementRepository->findOneBySlug(['slug' => $slug]);       
        
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
                ->setSupprime(0)
                ->setModifiePar($this->getUser())
                ->setModifieLeAt(new DateTime('now'))
                ;

                $this->em->persist($etatPaiement);
                $this->em->flush(); 

                $this->addFlash('info', 'Etat paiement modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                return $this->redirectToRoute('liste_etatPaiement', [
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

        #je récupère toutes mes etatPaiements non supprimées
        $etatPaiements = $this->etatPaiementRepository->findBy(['supprime' => 0]);

        return $this->render('etatPaiement/ajoutEtatPaiement.html.twig', [
            'slug' => $slug,
            'etatPaiement' => $etatPaiement,
            'etatPaiements' => $etatPaiements,
            'csrfToken' => $csrfToken,
            'ajoutEtatPaiementForm' => $form->createView(),
        ]);
    }
}
