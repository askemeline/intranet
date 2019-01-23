<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Entity\Note;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DisciplineRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(UserRepository $users, DisciplineRepository $discipline, NoteRepository $note, ObjectManager $manager)
    {
        if ($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY')){
            return $this->render('security/login.html.twig', [
                'controller_name' => 'MainController',
            ]);
        }
        // IF ADMIN CONNECT REDIRECT TO ADMIN
        else if($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('easyadmin');
        }
        //STUDENT
        else if ($this->isGranted('ROLE_USER')&& !$this->isGranted('ROLE_ADMIN')&& !$this->isGranted('ROLE_TEACHER')) {
            $user = $this->getUser();
            $disciplines = $discipline->findAll();
            $disciplines_user = $user->getDisciplines();
            $note_user = $user->getNotes();
            return $this->render('main/index.html.twig', [
                'user' => $user,
                'disciplines' => $disciplines,
                'disciplines_user' => $disciplines_user,
                'note' => $note_user,
            ]);
        }
        //TEACHER
        else{
            $user = $this->getUser();
            $lets= $users->findAll();
            $student = $discipline->findAll();
            $disciplines = $discipline->findAll();
            $discipline_teacher = $user->getDisciplines();
            return $this->render('main/index.html.twig', [
                'disciplines' => $disciplines,
                'discipline_teacher' => $discipline_teacher,
                'student' => $student,
                'lets' => $lets,
            ]);
        }
    }


    /**
     * @Route("/discipline/{id}/", name="discipline")
     */
    public function discipline(Request $request, ObjectManager $manager,DisciplineRepository $discipline,$id=null)
    {

        if ($this->isGranted('ROLE_USER')&& !$this->isGranted('ROLE_ADMIN')&& !$this->isGranted('ROLE_TEACHER')) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $discipline = $this->getDoctrine()->getRepository(Discipline::class)->find($id);
            $user->addDiscipline($discipline);
            $entityManager->flush();
        }
        return $this->redirectToRoute('main');
    }
}
