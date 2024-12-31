<?php

namespace App\Controller\Emprunt;

use App\Form\AjoutEmpruntType;
use App\Services\StrService;
use App\Repository\EmpruntRepository;
use DateTime;
use App\Services\QrCodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Espace reservé uniquement aux administrateurs')]
class ModifierEmpruntController extends AbstractController
{
    public function __construct(
        protected EmpruntRepository $empruntRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected QrCodeService $qrCodeService, 
        )
    { 
    }

    #[Route('/modifier-emprunt/{slug}', name: 'modifier_emprunt')]
    public function modifierEmprunt(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }
        

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $emprunt = $this->empruntRepository->findOneBy([
            'slug' => $slug
        ]); 
        
        $form = $this->createForm(AjoutEmpruntType::class, $emprunt);

        $form->handleRequest($request);
        
        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireEmprunt')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaireEmprunt = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireEmprunt', $csrfTokenFormulaireEmprunt))) 
            {
                /**
                 *@var User 
                 */
                $user = $this->getUser();
                
                $qrCode = $this->qrCodeService->generateQrCode("Cette emprunt appartient à : ".$emprunt->getMembre()->getNom()." Contact : ".$emprunt->getMembre()->getTelephone().", adresse : ".$emprunt->getMembre()->getAdresse().", email : ".$emprunt->getMembre()->getEmail().", NET A PAYER : ".$emprunt->getNombre() * $emprunt->getLivre()->getMontantEmprunt()."FCFA , Par : ".$user->getNom());


                $emprunt
                    ->setQrCode($qrCode)
                    ->setModifiePar($this->getUser())
                    ->setModifieLeAt(new DateTime('now'));
                $this->em->persist($emprunt);
                $this->em->flush(); 

                $this->addFlash('info', 'Emprunt modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                #je récupère tous les emprunts non supprimées
                $emprunts = $this->empruntRepository->findBy(['supprime' => 0]);
                return $this->render('emprunt/listeEmprunt.html.twig', [
                    'emprunts' => $emprunts,
                ]);
            } 
            else 
            {
                /**
                 * @var User
                 */
                $user = $this->getUser();
                $user->setBloque(1);
                return $this->redirectToRoute('app_logout');

            }
            
        }

        #je récupère tous les emprunts non supprimées pour afficher le nombre
        $emprunts = $this->empruntRepository->findBy(['supprime' => 0]);
        
        return $this->render('emprunt/ajoutEmprunt.html.twig', [
            'emprunts' => $emprunts,
            'emprunt' => $emprunt,
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'ajoutEmpruntForm' => $form->createView()
        ]);
    }
}
