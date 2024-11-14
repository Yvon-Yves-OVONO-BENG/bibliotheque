<?php

namespace App\Controller\Armoire;

use App\Entity\Armoire;
use App\Form\AjoutArmoireType;
use App\Repository\ArmoireRepository;
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
#[Route('/armoire')]
class AjoutArmoireController extends AbstractController
{
    public function __construct(
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected ArmoireRepository $armoireRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    ){}

    #[Route('/ajout-armoire', name: 'ajout_armoire')]
    public function ajoutArmoire(Request $request): Response
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

        $armoire = new Armoire;       
        
        $form = $this->createForm(AjoutArmoireType::class, $armoire);

        $form->handleRequest($request);

        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireArmoire')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaire = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireArmoire', $csrfTokenFormulaire))) 
            {
                $armoire->setArmoire($this->strService->strToUpper($armoire->getArmoire()))
                ->setSlug(uniqid('', true))
                ->setSupprime(0)
                ->setEnregistrePar($this->getUser())
                ->setEnregistreLeAt(new DateTime('now'))
                ;

                $this->em->persist($armoire);
                $this->em->flush(); 

                $this->addFlash('info', 'Armoire ajoutée avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('ajout', 1);

                $armoire = new Armoire();
                $form = $this->createForm(AjoutArmoireType::class, $armoire);

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

        #je récupère toutes mes armoires non supprimées
        $armoires = $this->armoireRepository->findBy(['supprime' => 0]);

        return $this->render('armoire/ajoutArmoire.html.twig', [
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'armoires' => $armoires,
            'ajoutArmoireForm' => $form->createView(),
        ]);
    }
}
