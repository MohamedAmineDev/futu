<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SondageRepository;
use App\Repository\QuestionLogiqueRepository;
use App\Form\QuestionType;
use App\Entity\QuestionLogique;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class QuestionLogiqueController extends AbstractController
{
    
    /**
     * @Route("/questions", name="question_index", methods={"GET"})
     */
    public function index(QuestionLogiqueRepository $questionRepository): Response
    {
        return $this->render('question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{idEnqueteur}/{idSondage}", name="question_new", methods={"GET","POST"})
     */
    public function new($idEnqueteur, $idSondage,Request $request, SondageRepository $sondageRepository): Response
    {
        $question = new QuestionLogique();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
       $sondage=$sondageRepository->find($idSondage);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $question->setSondage($sondage);
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('option_new',['idQuestion'=>$question->getId(),
                                                        'idEnqueteur'=>$idEnqueteur]);
        }

        return $this->render('question/new.html.twig', [
            'sondage' => $sondage,
            'question'=>$question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("question/{id}", name="question_show")
     * @ParamConverter("question", class="QuestionLogique:Post")
     */
    public function show(QuestionLogique $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="question_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, QuestionLogique $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('question_index');
        }

        return $this->render('question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="question_delete", methods={"DELETE"})
     */
    public function delete(Request $request, QuestionLogique $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('question_index');
    }
}
