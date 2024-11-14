<?php

namespace App\Controller\ModePaiement;

use DateTime;
use App\Services\StrService;
use App\Form\AjoutModePaiementType;
use App\Repository\ModePaiementRepository;
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
#[Route('/modePaiement')]
class ModifierModePaiementController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected ModePaiementRepository $modePaiementRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/modifier-modePaiement/{slug}', name: 'modifier_modePaiement')]
    public function modifierModePaiement(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $modePaiement = $this->modePaiementRepository->findOneBySlug(['slug' => $slug]);       
        
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
                ->setSupprime(0)
                ->setModifiePar($this->getUser())
                ->setModifieLeAt(new DateTime('now'))
                ;

                $this->em->persist($modePaiement);
                $this->em->flush(); 

                $this->addFlash('info', 'ModePaiement modifiée avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                return $this->redirectToRoute('liste_modePaiement', [
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

        #je récupère toutes mes modePaiements non supprimées
        $modePaiements = $this->modePaiementRepository->findBy(['supprime' => 0]);

        return $this->render('modePaiement/ajoutModePaiement.html.twig', [
            'slug' => $slug,
            'modePaiement' => $modePaiement,
            'modePaiements' => $modePaiements,
            'csrfToken' => $csrfToken,
            'ajoutModePaiementForm' => $form->createView(),
        ]);
    }
}
