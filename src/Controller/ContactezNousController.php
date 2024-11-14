<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactezNousController extends AbstractController
{
    #[Route('contactez-nous/{a<[0-1]{1}>}/{m<[0-1]{1}>}/{s<[0-1]{1}>}/{b}', name: 'contactez_nous')]
    public function contactezNous(Request $request, int $a = 0,  int $m = 0, int $s = 0, int $b = 0): Response
    {
        $mySession = $request->getSession();
        
        if(!$mySession)
        {
            return $this->redirectToRoute("app_logout");
        }

        if ($a == 0 || $m == 0 || $s == 0) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $mySession->set('ajout',null);
            $mySession->set('suppression', null);
            $mySession->set('miseAjour', null);
            
        }

        
        if ($a == 1) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $mySession->set('ajout',1);
            $mySession->set('suppression', null);
            $mySession->set('miseAjour', null);
            
        }

        #je teste si le témoin n'est pas vide pour savoir s'il vient de la mise à jour
        if ($m == 1) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $mySession->set('ajout', null);
            $mySession->set('suppression', null);
            $mySession->set('miseAjour', 1);
            
        }

        #je teste si le témoin n'est pas vide pour savoir s'il vient de la suppression
        if ($s == 1) 
        {
            $mySession->set('ajout',null);
            $mySession->set('suppression', 1);
            $mySession->set('miseAjour', null);
            
        }

        
        return $this->render('accueil/contactezNous.html.twig', [
           'b' => $b
        ]);
    }
}
