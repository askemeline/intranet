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

        else if ($this->isGranted('ROLE_USER')&& !$this->isGranted('ROLE_ADMIN')&& !$this->isGranted('ROLE_TEACHER')) {
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
            $user = $this->getUser();
            $disciplines = $discipline->findAll();
            $discipline_teacher = $user->getDisciplines();
                $student_user = $user->getFirstname();

                $student_register = $user->getFirstname();
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',

                'disciplines' => $disciplines,
                'student_register' => $student_register,
                'student_user' => $student_user,
                'discipline_teacher' => $discipline_teacher
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
