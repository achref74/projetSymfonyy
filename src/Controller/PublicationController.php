<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Forum;
use App\Entity\User;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/publication')]
class PublicationController extends AbstractController
{
    #[Route('/{idUser}/{idForum}', name: 'app_publication_index', methods: ['GET'])]
public function index(PublicationRepository $publicationRepository, int $idUser, int $idForum): Response
{
    // Retrieve publications based on $idForum
    $publications = $publicationRepository->findBy(['forum' => $idForum]);

    return $this->render('publication/index.html.twig', [
        'publications' => $publications,
        'idUser' => $idUser,
        'idForum' => $idForum,
    ]);
}

#[Route('/new/{idUser}/{idForum}', name: 'app_publication_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, int $idUser, int $idForum): Response
{
    $user = $entityManager->getRepository(User::class)->find($idUser);
    if (!$user) {
        throw $this->createNotFoundException('User not found');
    }

    $forum = $entityManager->getRepository(Forum::class)->find($idForum);
    if (!$forum) {
        throw $this->createNotFoundException('Forum not found');
    } 

    $publication = new Publication();
    $publication->setIduser($user);
    $publication->setIdforum($forum); 

    $form = $this->createForm(PublicationType::class, $publication);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($publication);
        $entityManager->flush();

        return $this->redirectToRoute('app_publication_index', [
            'idUser' => $idUser,
            'idForum' => $idForum,
        ], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('publication/new.html.twig', [
        'publication' => $publication,
        'form' => $form,
        'idUser' => $idUser,
            'idForum' => $idForum,
    ]);
}
    
    #[Route('/{idp}/edit/{idUser}/{idForum}', name: 'app_publication_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager,int $idUser,int $idForum): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form,
            'idUser' => $idUser,
            'idForum' => $idForum,
        ]);
    }

    #[Route('/{idUser}/{idForum}/delete/{idp}', name: 'app_publication_delete', methods: ['POST'])]
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager,int $idUser,int $idForum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getIdp(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publication_index', ['idUser' => $idUser,
        'idForum' => $idForum], Response::HTTP_SEE_OTHER);
    }
}
