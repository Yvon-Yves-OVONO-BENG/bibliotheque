<?php

namespace App\Controller\ModePaiement;

use App\Entity\ModePaiement;
use App\Form\AjoutModePaiementType;
use App\Repository\ModePaiementRepository;
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
#[Route('/modePaiement')]
class AjoutModePaiementController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected ModePaiementRepository $modePaiementRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/ajout-modePaiement', name: 'ajout_modePaiement')]
    public function ajoutModePaiement(Request $request): Response
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

        $modePaiement = new ModePaiement;       
        
        $form = $this->createForm(AjoutModePaiementType::class, $modePaiement);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireModePaiement')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireModePaiement', $csrfTokenFormulaire))) 
            {
                $modePaiement->setModePaiement($this->strService->strToUpper($modePaiement->getModePaiement()))
            ->setSlug(uniqid('', true))
            ->setSupprime(0)
            ->setEnregistrePar($this->getUser())
            ->setEnregistreLeAt(new DateTime('now'))
            ;

            $this->em->persist($modePaiement);
            $this->em->flush(); 

            $this->addFlash('info', 'Mode Paiement ajouté avec succès !');
            
            #j'affecte 1 à ma variable pour afficher le message
            $mySession->set('ajout', 1);

            $modePaiement = new ModePaiement();
            $form = $this->createForm(AjoutModePaiementType::class, $modePaiement);

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

        #je récupère toutes mes modePaiements non supprimées
        $modePaiements = $this->modePaiementRepository->findBy(['supprime' => 0]);

        return $this->render('modePaiement/ajoutModePaiement.html.twig', [
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'modePaiements' => $modePaiements,
            'ajoutModePaiementForm' => $form->createView(),
        ]);
    }
}
