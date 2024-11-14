<?php

namespace App\Controller\Livre;

use App\Entity\Livre;
use App\Entity\Photo;
use DateTimeImmutable;
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
class AjoutLivreController extends AbstractController
{
    public function __construct(
        protected LivreRepository $livreRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected StrService $strService,
        protected EntityManagerInterface $em
        )
    { 
    }

    #[Route('/ajout-livre', name: 'ajout_livre')]
    public function ajoutLivre(Request $request): Response
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

        $livre = new Livre(); 

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
                //Je récupère la photo principale du livre
                $imagePrincipale = $form->get('photo')->getData();
                $fichierPrincipal = md5(uniqid()) . '.' . $imagePrincipale->guessExtension();
                $imagePrincipale->move(
                    $this->getParameter('photo_directory'),
                    $fichierPrincipal
                );
                
                $livre->setTitre($this->strService->strToUpper($livre->getTitre()))
                ->setSlug(uniqid('', true))
                ->setEnregistrePar($this->getUser())
                ->setEnregistreLeAt(new DateTimeImmutable('now'))
                ->setPhoto($fichierPrincipal)
                ->setSupprime(0)
                ;

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
                
                $this->em->persist($livre);
                $this->em->flush(); 

                $this->addFlash('info', 'Livre ajouté avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('ajout', 1);

                $livre = new Livre();
                $form = $this->createForm(AjoutLivreType::class, $livre);

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
        #je récupère tous les livres non supprimées
        $livres = $this->livreRepository->findBy(['supprime' => 0]);

        return $this->render('livre/ajoutLivre.html.twig', [
            'livres' => $livres,
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'ajoutLivreForm' => $form->createView()
        ]);
    }
}
