<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\TwilioService;
#[Route('/reclamation')]
class ReclamationController extends AbstractController
{   
#[Route('/', name: 'app_reclamation_index', methods: ['GET', 'POST'])]
public function index(Request $request, ReclamationRepository $reclamationRepository): Response
{
    // Retrieve all reclamations
    $reclamations = $reclamationRepository->findAll();

    // Calculate statistics
    $formationCounts = [];
    foreach ($reclamations as $reclamation) {
        $formationName = $reclamation->getFormation()->getNom();
        if (!isset($formationCounts[$formationName])) {
            $formationCounts[$formationName] = 0;
        }
        $formationCounts[$formationName]++;
    }

    // Prepare data for the Google Pie Chart
    $chartData = [];
    foreach ($formationCounts as $formationName => $count) {
        $chartData[] = [$formationName, $count];
    }

    // If it's an AJAX request, return only the reclamations list
    if ($request->isXmlHttpRequest()) {
        $searchTerm = $request->request->get('searchTerm');
        $reclamations = $reclamationRepository->findBySearchTerm($searchTerm);

        return $this->render('reclamation/_reclamation_list.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    // Otherwise, return the reclamations list along with the statistics data
    return $this->render('reclamation/index.html.twig', [
        'reclamations' => $reclamations,
        'chartData' => $chartData,
    ]);
}

/*public function index(Request $request, ReclamationRepository $reclamationRepository ): Response
{
    if ($request->isXmlHttpRequest()) {
        $searchTerm = $request->request->get('searchTerm');
        
        $reclamations = $reclamationRepository->findBySearchTerm($searchTerm);

        return $this->render('reclamation/_reclamation_list.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    return $this->render('reclamation/index.html.twig', [
        'reclamations' => $reclamationRepository->findAll(),
    ]);
}*/

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {   $twilioService = new TwilioService();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $badWords = ['fuck', 'bitch','cancer','nigger','shit','badword'];
            $reclamationText = $reclamation->getDescription();
            $reclamationUser = $reclamation->getUser()->getNom();
            $reclamationDate = $reclamation->getDate() ? $reclamation->getDate()->format('Y-m-d H:i:s') : '';
            $reclamationFormation = $reclamation->getFormation()->getNom();
            $reclamationUserid = $reclamation->getUser()->getIduser();

            $userPhone = '+21655756823';
            $twilioNumber = '+14155238886';
       
            
            if ($this->containsBadWords($reclamationText, $badWords)) {
                // Return a response indicating that the reclamation contains bad words
                $this->addFlash('error', 'Your reclamation contains inappropriate language. Please revise.');
                return $this->redirectToRoute('app_reclamation_new');
            }
    
            $entityManager->persist($reclamation);
            $entityManager->flush();
            $twilioService->sendWhatsAppMessage($userPhone, $twilioNumber, "The user ".$reclamationUser." has sent a claim saying \n ".$reclamationText."\n about the formation :".$reclamationFormation);

            $this->addFlash('success', 'Reclamation created successfully.');
            return $this->redirectToRoute('app_reclamation_client', ['id_user' => $reclamationUserid], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    
    // Function to check for bad words
   
    
   

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(ReclamationType::class, $reclamation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $reclamationText = $reclamation->getDescription();
        $badWords = ['fuck', 'bitch','cancer','nigger','shit','badword'];
        if ($this->containsBadWords($reclamationText, $badWords)) {
            // Return a response indicating that the reclamation contains bad words
            $this->addFlash('error', 'Your reclamation contains inappropriate language. Please revise.');
            return $this->redirectToRoute('app_reclamation_edit');
        }
        $entityManager->flush();
        $this->addFlash('success', 'Reclamation created successfully.');

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('reclamation/edit.html.twig', [
        'reclamation' => $reclamation,
        'form' => $form,
    ]);
}

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        /*$reclamation = $entityManager->getRepository(Reclamation::class)->find($id);
        if (!$reclamation){
            throw $this->createNotFoundException('reclamtion not found');
        }*/
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    public function sendWhatsApp(TwilioService $twilioService): Response
    {
        
        $to = "whatsapp:+21655756823"; // e.g., +1234567890
        $from = "whatsapp:+14155238886"; // e.g., +14155238886
        $body = "Your Yummy Cupcakes Company order of 1 dozen frosted cupcakes has shipped and should be delivered on July 10, 2019. Details: http://www.yummycupcakes.com/";

        $message = $twilioService->sendWhatsAppMessage($to, $from, $body);

        // Handle response as needed
        return new Response($message->sid);
    }
    public function containsBadWords($text, $badWords)
    {
        foreach ($badWords as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }
    #[Route('/user/{id_user}', name: 'app_reclamation_client', methods: ['GET', 'POST'])]
    public function indexClient(Request $request, ReclamationRepository $reclamationRepository, int $id_user,UserRepository $userRepository): Response
    {
        // Retrieve the user object
        $user = $userRepository->find($id_user);
    
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
    
        // Retrieve all reclamations associated with the user
        $reclamations = $reclamationRepository->findBy(['user' => $user]);
    
        // Calculate statistics
        $formationCounts = [];
        foreach ($reclamations as $reclamation) {
            $formationName = $reclamation->getFormation()->getNom();
            if (!isset($formationCounts[$formationName])) {
                $formationCounts[$formationName] = 0;
            }
            $formationCounts[$formationName]++;
        }
    
        // Prepare data for the Google Pie Chart
        $chartData = [];
        foreach ($formationCounts as $formationName => $count) {
            $chartData[] = [$formationName, $count];
        }
    
        // If it's an AJAX request, return only the reclamations list
        if ($request->isXmlHttpRequest()) {
            $searchTerm = $request->request->get('searchTerm');
            $reclamations = $reclamationRepository->findBySearchTermAndUserId($searchTerm,$id_user);
    
            return $this->render('reclamation/_reclamation_list_foruser.html.twig', [
                'reclamations' => $reclamations,
                'id_user' => $id_user,
            ]);
        }
    
        // Otherwise, return the reclamations list along with the statistics data
        return $this->render('reclamation/indexClient.html.twig', [
            'reclamations' => $reclamations,
            'chartData' => $chartData,
            'id_user' => $id_user,
        ]);
    }
    
   
}
