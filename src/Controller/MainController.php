<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DisciplineRepository;
use App\Repository\UserRepository;

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
        }
        else if($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('easyadmin');
        }
        else if($this->isGranted('ROLE_STUDENT')){
            return $this->redirectToRoute('view_student');
        }
        else{
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
            ]);
        }
    }
    /**
     * @Route("/student", name="view_student")
     */
    public function view_student(UserRepository $user, DisciplineRepository $discipline, NoteRepository $note)
        {

        $user = $this -> getUser();
        $disciplines = $discipline -> findAll();
        $disciplines_user = $user->getDisciplines();
        #$notes = $note ->findAll();
        $note_user = $user->getNotes();

            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
                'user'=>$user,
                'disciplines'=>$disciplines,
                'disciplines_user' => $disciplines_user,
                'note' => $note_user,
            ]);

        }

}
