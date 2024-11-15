<?php

namespace App\Controller;

use App\Entity\ConstantsClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/{a<[0-1]{1}>}/{m<[0-1]{1}>}/{s<[0-1]{1}>}/{b}', name: 'accueil')]
    public function accueil(Request $request, int $a = 0,  int $m = 0, int $s = 0, int $b = 0): Response
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

        if ($this->getUser() && in_array(ConstantsClass::ROLE_ADMIN, $this->getUser()->getRoles())) 
        {
            return $this->render('accueil/indexAdmin.html.twig', [
                'b' => $b
             ]);

        } 
        else 
        {
            return $this->render('accueil/index.html.twig', [
           'b' => $b
        ]);
        }
        
        
    }
}
