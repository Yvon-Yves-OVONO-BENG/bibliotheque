<?php

namespace App\Controller\Emprunt;

use DateTimeImmutable;
use App\Entity\Emprunt;
use App\Entity\LigneEmprunt;
use App\Services\StrService;
use App\Form\AjoutEmpruntType;
use App\Services\QrCodeService;
use App\Repository\EmpruntRepository;
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
class AjoutEmpruntController extends AbstractController
{
    public function __construct(
        protected EmpruntRepository $empruntRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected StrService $strService,
        protected EntityManagerInterface $em,
        protected QrCodeService $qrCodeService, 
        protected LivreRepository $livreRepository
        )
    { 
    }

    #[Route('/ajout-emprunt', name: 'ajout_emprunt')]
    public function ajoutEmprunt(Request $request): Response
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

        $emprunt = new Emprunt(); 

        $form = $this->createForm(AjoutEmpruntType::class, $emprunt);

        $form->handleRequest($request);
        
        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('envoieFormulaireEmprunt')->getValue();

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $qrCode = null;

            $csrfTokenFormulaireEmprunt = $request->request->get('csrfToken');

            if ($this->csrfTokenManager->isTokenValid(
                new CsrfToken('envoieFormulaireEmprunt', $csrfTokenFormulaireEmprunt))) 
            {
                //je récupère la date courante
                $now = new \DateTime('now');

                ///j'extrais le jour de la date du jour en numérique
                $jour = $now->format('d');

                ///j'exrais le mois de la date du jour en numérique
                $mois = $now->format('m');

                ///j'extrais l'annéé de la dat du jour en numérique
                $annee = $now->format('Y');

                $annee = substr($annee, 2, 2);

                //////j'extrait le dernier emprunt emprunt de la table
                $derniereEmprunt = $this->empruntRepository->findBy([],['id' => 'DESC'],1,0);

                if(!$derniereEmprunt)
                {
                    $id = 1;
                }
                else
                {
                    /////je récupère l'id de la dernière emprunt
                    $id = $derniereEmprunt[0]->getId();

                }

                /////je construis la référence
                $reference = 'BB-'.$id.$jour.$mois.$annee;

                /**
                 *@var User 
                 */
                $user = $this->getUser();
                
                $netApayer = 0;

                foreach ($emprunt->getLigneEmprunts() as $ligneEmprunt) 
                {
                    $netApayer += $ligneEmprunt->getQuantite()*$ligneEmprunt->getLivre()->getMontantEmprunt();
                    
                }

                $qrCode = $this->qrCodeService->generateQrCode("Cette facture appartient à : ".$emprunt->getMembre()->getNom()." Contact : ".$emprunt->getMembre()->getTelephone().", adresse : ".$emprunt->getMembre()->getAdresse().", email : ".$emprunt->getMembre()->getEmail().", NET A PAYER : ".$netApayer."FCFA , Par : ".$user->getNom());

                $emprunt
                ->setQrCode($qrCode)
                ->setNetAPayer($netApayer)
                ->setReference($reference)
                ->setSlug(uniqid('', true))
                ->setEnregistrePar($this->getUser())
                ->setDateEmpruntAt(new DateTimeImmutable('now'))
                ->setSupprime(0)
                ;

                $this->em->persist($emprunt);

                // dd($emprunt->getLigneEmprunts()); // Vérifiez la source des données
                foreach ($emprunt->getLigneEmprunts() as $ligneEmprunt) 
                {
                    $ligneEmprun = new LigneEmprunt();
                    $ligneEmprun
                        ->setEmprunt($emprunt)
                        ->setLivre($ligneEmprunt->getLivre())
                        ->setQuantite($ligneEmprunt->getQuantite())
                        ->setDateRetourPrevueAt($ligneEmprunt->getDateRetourPrevueAt())
                        ->setMontant($ligneEmprunt->getMontant());

                    // dd($ligneEmprun); // Vérifiez chaque instance créée
                    $this->em->persist($ligneEmprun);
                }
                
                
                #c'est pour vérifier l'état des entités Doctrine
                dd($this->em->getUnitOfWork()->getScheduledEntityInsertions());
                $this->em->flush(); 

                $this->addFlash('info', 'Emprunt ajouté avec succès !');
                
                #j'affecte 1 à ma variable pour afficher le message
                $mySession->set('ajout', 1);

                $emprunt = new Emprunt();
                $form = $this->createForm(AjoutEmpruntType::class, $emprunt);

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
        #je récupère tous les emprunts non supprimées
        $emprunts = $this->empruntRepository->findBy(['supprime' => 0]);

        return $this->render('emprunt/ajoutEmprunt.html.twig', [
            'emprunts' => $emprunts,
            'slug' => $slug,
            'csrfToken' => $csrfToken,
            'ajoutEmpruntForm' => $form->createView()
        ]);
    }
}
