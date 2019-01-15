<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        if ($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY')){

        return $this->render('security/login.html.twig', [
            'controller_name' => 'MainController',
        ]);
        }else{
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
            ]);
        }
    }
}
