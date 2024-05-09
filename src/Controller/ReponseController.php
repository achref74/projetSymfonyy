<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Reclamation;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\ReponseType;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reponse')]
class ReponseController extends AbstractController
{
    #[Route('/', name: 'app_reponse_index', methods: ['GET'])]
    public function index(ReponseRepository $reponseRepository): Response
    {
        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponseRepository->findAll(),
        ]);
    }

    #[Route('/list/{reclamationId}', name: 'app_reponse_sh', methods: ['GET'])]
    public function indexreponse(ReponseRepository $reponseRepository,ReclamationRepository $reclamationRepository,$reclamationId ): Response
    {        $reclamation = $reclamationRepository->find($reclamationId);

        return $this->render('reponse/reponseByreclamation.html.twig', [
            'reponses' => $reponseRepository->findby(['reclamation' => $reclamation]),
        ]);
    }

    #[Route('/new/{reclamationId}/{idUser}', name: 'app_reponse_new', methods: ['GET', 'POST'])]
public function new(AuthenticationUtils $authenticationUtils,Request $request, EntityManagerInterface $entityManager, $reclamationId, int $idUser): Response
{
    $user = $entityManager->getRepository(User::class)->find($idUser);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        $userRepository = $entityManager->getRepository(User::class);
        $uEmail = $user->getEmailAuthRecipient();
        $user = $userRepository->findOneBy(['email' => $uEmail]);
    // Fetch the Reclamation entity by its ID
    $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($reclamationId);

    // Create a new Reponse entity
    $reponse = new Reponse();
    $reponse->setuser($user);
    $reponse->setReclamation($reclamation); // Set the Reclamation entity

    $form = $this->createForm(ReponseType::class, $reponse);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($reponse);
        $entityManager->flush();

        return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('reponse/new.html.twig', [
        'reponse' => $reponse,
        'form' => $form,
    ]);
}

    #[Route('/{id}', name: 'app_reponse_show', methods: ['GET'])]
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reponse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponse/edit.html.twig', [
            'reponse' => $reponse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_delete', methods: ['POST'])]
    public function delete(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
    }
}
