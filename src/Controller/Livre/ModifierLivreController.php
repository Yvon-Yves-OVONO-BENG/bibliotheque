<?php

namespace App\Controller\Livre;

use App\Entity\Photo;
use App\Form\AjoutLivreType;
use App\Services\StrService;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER', message: 'Accès refusé. Espace reservé uniquement aux administrateurs')]
class ModifierLivreController extends AbstractController
{
    public function __construct(
        protected LivreRepository $livreRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected StrService $strService,
        protected EntityManagerInterface $em
        )
    { 
    }

    #[Route('/modifier-livre/{slug}', name: 'modifier_livre')]
    public function modifierLivre(Request $request, string $slug): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }
        

        $mySession->set('ajout',null);
        $mySession->set('suppression', null);
        $mySession->set('miseAjour', null);

        $livre = $this->livreRepository->findOneBy([
            'slug' => $slug
        ]); 
        
        $form = $this->createForm(AjoutLivreType::class, $livre);

        $form->handleRequest($request);
        
        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireLivre')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $csrfTokenFormulaireLivre = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireLivre', $csrfTokenFormulaireLivre))) 
            {
                if ($form->get('photo')->getData()) { 
                    //Je récupère la photo principale du livre
                    $imagePrincipale = $form->get('photo')->getData();
                    $fichierPrincipal = md5(uniqid()) . '.' . $imagePrincipale->guessExtension();
                    $imagePrincipale->move(
                        $this->getParameter('photo_directory'),
                        $fichierPrincipal
                    );
                    $livre->setPhoto($fichierPrincipal);
                }
                
                if ($form->get('photos')->getData()) {
                    //Je récuppère les autres images du livre pour uploader 
                    $images = $form->get('photos')->getData();
                    foreach ($images as $image) {
                        $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                        $image->move(
                            $this->getParameter('photo_directory'),
                            $fichier
                        );
                        $img = new Photo;
                        $img->setPhoto($fichier)
                            ->setSlug(md5(uniqid()));
                        $livre->addPhoto($img);
                        $this->em->persist($img);
                    }
                }
                
                $livre->setTitre($this->strService->strToUpper($livre->getTitre()));
                $this->em->persist($livre);
                $this->em->flush(); 

                $this->addFlash('info', 'Livre modifié avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('miseAjour', 1);

                #je récupère tous les livres non supprimées
                $livres = $this->livreRepository->findBy(['supprime' => 0]);
                return $this->render('livre/listeLivre.html.twig', [
                    'livres' => $livres,
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

        #je récupère tous les livres non supprimées pour afficher le nombre
        $livres = $this->livreRepository->findBy(['supprime' => 0]);
        
        return $this->render('livre/ajoutLivre.html.twig', [
            'livres' => $livres,
            'livre' => $livre,
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'ajoutLivreForm' => $form->createView()
        ]);
    }
}
