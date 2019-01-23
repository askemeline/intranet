<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Repository\DisciplineRepository;
use App\Entity\User;
use App\Service\NoteManager;

/**
 * @Route("/note")
 */
class NoteController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_TEACHER')")
     * @Route("/new", name="note_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class);

        $user = $this->getUser();

        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
            'user'=>$user,
        ]);
    }




    /**
     * @Route("/general_grade/{user}", name="note_general")
     */
    public function general_grade(NoteManager $noteManager, NoteRepository $repo, User $user, DisciplineRepository $disciplie)
    {
        if ($this->isGranted('ROLE_USER')&& !$this->isGranted('ROLE_ADMIN')&& !$this->isGranted('ROLE_TEACHER')) {

            $user = $this->getUser();
        $notes=$repo->findBy(['user' => $user]);
        $avg = $noteManager->getAverage($notes);

        return $this->render('note/general_grade.html.twig', [
            'avg' => $avg,
            'user' => $user,
            'note'=>$notes,


        ]);
        }else{
            return $this->redirectToRoute('main');
        }
    }



}
