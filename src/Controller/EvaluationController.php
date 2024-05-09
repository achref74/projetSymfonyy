<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\Cours;
use App\Form\EvaluationType;
use App\Repository\EvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Question;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\QuestionRepository;
use Twilio\Rest\Client;


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

    #[Route('/{coursId}/questions', name: 'evaluation_questions', methods: ['GET'])]
    public function questions(QuestionRepository $questionRepository, Request $request, int $coursId,
    EvaluationRepository $evaluationRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cours = $entityManager->getRepository(Cours::class)->find($coursId);
    
        if (!$cours) {
            throw $this->createNotFoundException('No cours found for id ' . $coursId);
        }
        $evaluation = $evaluationRepository->findOneBy(
            ['cours' => $cours], // Filter by the specific course
            ['id' => 'DESC'] // Order by evaluation ID in descending order
        );    
        if (!$evaluation) {
            throw $this->createNotFoundException('No evaluation found for cours_id ' . $coursId);
        }
         $questions = $questionRepository->findByEvaluationAndCourseIds($coursId);
    
        $totalQuestions = count($questions);
    
        $currentQuestionIndex = $request->query->getInt('index', 0);
        $currentQuestion = $questions[$currentQuestionIndex] ?? null;
        if($currentQuestionIndex ==0){
            $note =0;
        }
        $note = rand(0, 20);

        $selectedValue = $request->query->get('selectedValue');
        if ($selectedValue==$currentQuestion->getChoix1() && "1" == $currentQuestion->getCrx()) {
            $note +=$currentQuestion->getPoint();
            if ($selectedValue==$currentQuestion->getChoix2() && "2" == $currentQuestion->getCrx()) {
                $note +=$currentQuestion->getPoint();
        }elseif ($selectedValue==$currentQuestion->getChoix3() && "3" == $currentQuestion->getCrx()) {
            $note +=$currentQuestion->getPoint();

        }}


    
       
    
        return $this->render('evaluation/test_evaluation.html.twig', [
            'currentQuestion' => $currentQuestion,
            'currentQuestionIndex' => $currentQuestionIndex,
            'totalQuestions' => $totalQuestions,
            'evaluationId' => $evaluation->getId(),
            'questionss' => $questions,
            'cours' => $cours,
            'note' => $note


        ]);
    }
    
    #[Route('/resultat/{id}/{note}', name: 'resultat', methods: ['GET'])]
    public function resultat(Request $request, int $id, int $note): Response
    {
    
 
    
        $twilio = new Client($twilioSid, $twilioToken);
    
        // Send SMS
        $message = $twilio->messages
            ->create(
                '+21622844480', // to
                [
                    "from" => "+14328474956",
                    "body" => "votre note : " . $note
                ]
            );
    
        return $this->render('evaluation/resultat.html.twig', [
            'note' => $note,
        ]);
    }



    #[Route('/new/{id}', name: 'app_evaluation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, int $id): Response
    {    
        $entityManager = $this->getDoctrine()->getManager();
        $course = $entityManager->getRepository(Cours::class)->find($id);
    
        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        $evaluation = new Evaluation();
        $evaluation->setCours($course);
        $form = $this->createForm(EvaluationType::class, $evaluation);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evaluation);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index');
        }

        return $this->render('evaluation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_evaluation_show', methods: ['GET'])]
    public function show(Evaluation $evaluation): Response
    {
        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }


    #[Route('/{coursId}/edit', name: 'app_evaluation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $coursId): Response
    {
        // $evaluation = $entityManager->getRepository(Evaluation::class)->findOneBy(['cours' => $coursId]);
        $evaluation = $entityManager->getRepository(Evaluation::class)
    ->createQueryBuilder('e')
    ->andWhere('e.cours = :coursId')
    ->setParameter('coursId', $coursId)
    ->orderBy('e.id', 'DESC') // Order by ID in descending order to get the latest
    ->setMaxResults(1) // Limit the result to only one record (the latest)
    ->getQuery()
    ->getOneOrNullResult();
        $cours = $entityManager->getRepository(Cours::class)->find($coursId);
        $questions = $entityManager->getRepository(Question::class)->findBy(['evaluation' => $evaluation]);

        if (!$evaluation) {
            throw $this->createNotFoundException('No evaluation found for cours_id ' . $coursId);
        }
    
        $originalQuestions = new ArrayCollection();
    
        foreach ($evaluation->getQuestions() as $question) {
            $originalQuestions->add($question);
        }
    
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalQuestions as $question) {
                if (false === $evaluation->getQuestions()->contains($question)) {
                    $entityManager->remove($question);
                }
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('evaluation/edit.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form,
            'cour' =>$cours,
            'questions'=>$questions,
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
