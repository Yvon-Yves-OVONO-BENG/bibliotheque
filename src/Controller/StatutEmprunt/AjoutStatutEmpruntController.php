<?php

namespace App\Controller\StatutEmprunt;

use App\Entity\StatutEmprunt;
use App\Form\AjoutStatutEmpruntType;
use App\Repository\StatutEmpruntRepository;
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
#[Route('/statutEmprunt')]
class AjoutStatutEmpruntController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected StatutEmpruntRepository $statutEmpruntRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/ajout-statut-emprunt', name: 'ajout_statutEmprunt')]
    public function ajoutStatutEmprunt(Request $request): Response
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

        $statutEmprunt = new StatutEmprunt;       
        
        $form = $this->createForm(AjoutStatutEmpruntType::class, $statutEmprunt);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireStatutEmprunt')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireStatutEmprunt', $csrfTokenFormulaire))) 
            {
                $statutEmprunt->setStatutEmprunt($this->strService->strToUpper($statutEmprunt->getStatutEmprunt()))
            ->setSlug(uniqid('', true))
            ->setSupprime(0)
            ->setEnregistrePar($this->getUser())
            ->setEnregistreLeAt(new DateTime('now'))
            ;

            $this->em->persist($statutEmprunt);
            $this->em->flush(); 

            $this->addFlash('info', 'Statut emprunt ajouté avec succès !');
            
            #j'affecte 1 à ma variable pour afficher le message
            $mySession->set('ajout', 1);

            $statutEmprunt = new StatutEmprunt();
            $form = $this->createForm(AjoutStatutEmpruntType::class, $statutEmprunt);

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

        #je récupère toutes mes statutEmprunts non supprimées
        $statutEmprunts = $this->statutEmpruntRepository->findBy(['supprime' => 0]);

        return $this->render('statutEmprunt/ajoutStatutEmprunt.html.twig', [
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'statutEmprunts' => $statutEmprunts,
            'ajoutStatutEmpruntForm' => $form->createView(),
        ]);
    }
}
