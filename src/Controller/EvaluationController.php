<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Form\EvaluationType;
use App\Repository\EvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Question;

#[Route('/evaluation')]
class EvaluationController extends AbstractController
{
    #[Route('/', name: 'app_evaluation_index', methods: ['GET'])]
    public function index(EvaluationRepository $evaluationRepository): Response
    {
        return $this->render('evaluation/index.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_evaluation_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        // $evaluation = new Evaluation();
        // $form = $this->createForm(EvaluationType::class, $evaluation);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($evaluation);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('evaluation_index');
        // }

        // return $this->render('evaluation/_form.html.twig', [
        //     'evaluation' => $evaluation,
        //     'form' => $form->createView(),
        // ]);
 $entityManager = $this->getDoctrine()->getManager();

    $evaluation = new Evaluation();

    // Pre-populate with 5 empty question forms
    for ($i = 0; $i < 5; $i++) {
        $question = new Question();
        $evaluation->addQuestion($question);
    }

    $form = $this->createForm(EvaluationType::class, $evaluation);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Persist and flush the Evaluation entity
        $entityManager->persist($evaluation);
        $entityManager->flush();

        // Handle questions
        foreach ($evaluation->getQuestions() as $question) {
            $question->setEvaluation($evaluation);
            $entityManager->persist($question);
        }

        $entityManager->flush();

        return $this->redirectToRoute('evaluation_index');
    }

    return $this->render('evaluation/new.html.twig', [
        'form' => $form->createView(),
    ]);

    }


#[Route('/add-question', name: 'add_question_to_evaluation', methods: ['POST'])]
public function addQuestionToEvaluation(Request $request): Response
{
    $evaluation = new Evaluation();
    $form = $this->createForm(EvaluationType::class, $evaluation);

    $question = new Question();
    $evaluation->getQuestions()->add($question);
    
    $questionForm = $this->renderView('evaluation/_question_form.html.twig', [
        'questionForm' => $form['questions']->createView(),
    ]);

    return new Response($questionForm);
}

    #[Route('/{id}', name: 'app_evaluation_show', methods: ['GET'])]
    public function show(Evaluation $evaluation): Response
    {
        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evaluation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evaluation $evaluation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evaluation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evaluation/edit.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evaluation_delete', methods: ['POST'])]
    public function delete(Request $request, Evaluation $evaluation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evaluation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evaluation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evaluation_index', [], Response::HTTP_SEE_OTHER);
    }
}
