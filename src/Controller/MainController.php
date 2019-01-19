<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DisciplineRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class MainController extends AbstractController
{

    public function adminDashboard()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // ...
    }


    /**
     * @Route("/", name="main")
     */
    public function index(UserRepository $user, DisciplineRepository $discipline, NoteRepository $note)
    {
        if ($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY')){
            return $this->render('security/login.html.twig', [
                'controller_name' => 'MainController',
            ]);
        }
        else if($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('easyadmin');
        }

        else if ($this->isGranted('ROLE_USER')&& !$this->isGranted('ROLE_ADMIN')) {
            $user = $this->getUser();
            $disciplines = $discipline->findAll();
            $disciplines_user = $user->getDisciplines();
            $note_user = $user->getNotes();
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
                'user' => $user,
                'disciplines' => $disciplines,
                'disciplines_user' => $disciplines_user,
                'note' => $note_user,
            ]);
        }
        else{
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
            ]);
        }

    }


}
