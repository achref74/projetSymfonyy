<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Repository\ForumRepository;
use App\Form\ForumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;


#[Route('/forum')]
class ForumController extends AbstractController
{
    #[Route('/{idformation}', name: 'app_forum_index', methods: ['GET'])]
    public function index(ForumRepository $forumRepository , int $idformation): Response
    {
        return $this->render('forum/index.html.twig', [
            'forums' => $forumRepository->findAll(),
            'idformation' => $idformation,
                ]);
    }

    #[Route('/client/{idformation}/{idUser}', name: 'Front_forum_index', methods: ['GET'])]
    public function indexFront(ForumRepository $forumRepository , int $idformation, int $idUser): Response
    {
        return $this->render('forum/indexFront.html.twig', [
            'forums' => $forumRepository->findAll(),
            'idformation' => $idformation,
            'idUser' => $idUser,
                ]);
    }

    #[Route('/new/{idformation}', name: 'app_forum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager , int $idformation): Response
    {


        $formation = $entityManager->getRepository(Formation::class)->find($idformation);

        if (!$formation) {
            throw $this->createNotFoundException('Formation not found');
        }
        $forum = new Forum();
        $forum->setIdformation($formation); // Set the Formation entity on the Forum entity
    
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($forum);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_forum_index', [
                'idformation' => $idformation, ], Response::HTTP_SEE_OTHER);
                    }
    
        return $this->renderForm('forum/new.html.twig', [
            'forum' => $forum,
            'form' => $form,
            'idformation' => $idformation,
        ]);
    }
    #[Route('/new/client/{idformation}', name: 'Front_forum_new', methods: ['GET', 'POST'])]
    public function newFront(Request $request, EntityManagerInterface $entityManager , int $idformation): Response
    {


        $formation = $entityManager->getRepository(Formation::class)->find($idformation);

        if (!$formation) {
            throw $this->createNotFoundException('Formation not found');
        }$forum = new Forum();
        $forum->setIdformation($formation); // Set the Formation entity on the Forum entity
    
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($forum);
            $entityManager->flush();
    
            return $this->redirectToRoute('Front_forum_index', [
                'idformation' => $idformation, ], Response::HTTP_SEE_OTHER);
                    }
    
        return $this->renderForm('forum/newFront.html.twig', [
            'forum' => $forum,
            'form' => $form,
            'idformation' => $idformation,
        ]);
    }

    #[Route('/Show/{idformation}/{idforum}', name: 'app_forum_show', methods: ['GET'])]
    public function show(Forum $forum , int $idformation): Response
    {
        return $this->render('forum/show.html.twig', [
            'forum' => $forum,
            'idformation' => $idformation,

        ]);
    }

    #[Route('/{idformation}/edit/{idforum}', name: 'app_forum_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, EntityManagerInterface $entityManager, int $idformation, int $idforum): Response
{
    // Find the Forum entity by its identifier
    $forum = $entityManager->getRepository(Forum::class)->find($idforum);

    // Check if the Forum entity was found
    if (!$forum) {
        throw $this->createNotFoundException('Forum not found');
    }

    $form = $this->createForm(ForumType::class, $forum);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_forum_index', [
            'idformation' => $idformation, 
        ], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('forum/edit.html.twig', [
        'forum' => $forum,
        'form' => $form,
        'idformation' => $idformation,
    ]);
}

#[Route('/{idformation}/delete/{idforum}', name: 'app_forum_delete', methods: ['POST'])]
public function delete(Request $request, Forum $forum, EntityManagerInterface $entityManager, int $idformation, int $idforum): Response
{
    // Find the Forum entity by its identifier
    $forum = $entityManager->getRepository(Forum::class)->find($idforum);

    // Check if the Forum entity was found
    if (!$forum) {
        throw $this->createNotFoundException('Forum not found');
    }
    if ($this->isCsrfTokenValid('delete'.$forum->getIdforum(), $request->request->get('_token'))) {
        $entityManager->remove($forum);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_forum_index', ['idformation' => $idformation], Response::HTTP_SEE_OTHER);
}

}
