<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;




#[Route('/reclamation')]
class ReclamationController extends AbstractController
{

    #[Route('/', name: 'app_reclamation_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $searchTerm = $request->request->get('searchTerm');
            $reclamations = $reclamationRepository->findBySearchTerm($searchTerm);
            $data1 = $reclamationRepository->calculStat();
            return $this->render('reclamation/_reclamation_list.html.twig', [
                'reclamations' => $reclamations,
                'data1'=> $data1 , 
            ]);
        }
    
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
    


    

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $badWords = ['fuck', 'bitch','cancer','nigger','shit','badword'];
            $reclamationText = $reclamation->getDescription(); // Adjust this according to your Reclamation entity
    
            if ($this->containsBadWords($reclamationText, $badWords)) {
                // Return a response indicating that the reclamation contains bad words
                $this->addFlash('error', 'Your reclamation contains inappropriate language. Please revise.');
                return $this->redirectToRoute('app_reclamation_new');
            }
    
            $entityManager->persist($reclamation);
            $entityManager->flush();
    
            $this->addFlash('success', 'Reclamation created successfully.');
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    
    // Function to check for bad words
    private function containsBadWords($text, $badWords)
    {
        foreach ($badWords as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }
    
   /* #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }*/

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
            $entityManager->flush();

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
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
