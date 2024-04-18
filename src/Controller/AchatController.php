<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Outil;
use App\Form\AchatType;
use App\Repository\AchatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/achat')]
class AchatController extends AbstractController
{
    #[Route('/', name: 'app_achat_index', methods: ['GET'])]
    public function index(AchatRepository $achatRepository): Response
    {
        return $this->render('achat/index.html.twig', [
            'achats' => $achatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_achat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $achat = new Achat();
        $outilId = $request->query->get('outilId');  // Get outilId from query parameters
        $total = $request->query->get('total');  // Get total from query parameters

        if ($outilId && $total) {
            $outil = $entityManager->getRepository(Outil::class)->find($outilId);
            $achat->setOutil($outil);
            $achat->setTotal($total);
            $achat->setDate(new \DateTime());

            $entityManager->persist($achat);
            $entityManager->flush();

            return $this->redirectToRoute('app_achat_showFront', ['id' => $achat->getId()], Response::HTTP_SEE_OTHER);
        }

        // Fallback in case no parameters were passed or outil was not found
        return $this->renderForm('achat/new.html.twig', [
            'achat' => $achat,
            'form' => $this->createForm(AchatType::class, $achat),
        ]);
    }


    #[Route('/{id}', name: 'app_achat_show', methods: ['GET'])]
    public function show(Achat $achat): Response
    {
        return $this->render('achat/show.html.twig', [
            'achat' => $achat,
        ]);
    }
    #[Route('/{id}/front', name: 'app_achat_showFront', methods: ['GET'])]
    public function showFront(Achat $achat): Response
    {
        return $this->render('achat/showFront.html.twig', [
            'achat' => $achat,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_achat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Achat $achat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('achat/edit.html.twig', [
            'achat' => $achat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_achat_delete', methods: ['POST'])]
    public function delete(Request $request, Achat $achat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$achat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($achat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_achat_index', [], Response::HTTP_SEE_OTHER);
    }
}
