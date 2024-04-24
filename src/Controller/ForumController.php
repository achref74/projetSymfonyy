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
use Knp\Component\Pager\PaginatorInterface;


#[Route('/forum')]
class ForumController extends AbstractController
{
    
#[Route('/{idformation}/{idUser}', name: 'app_forum_index', methods: ['GET'])]
public function index(ForumRepository $forumRepository, int $idformation, int $idUser): Response
{
    // Récupérer tous les forums
    $forums = $forumRepository->findAll();

    return $this->render('forum/index.html.twig', [
        'forums' => $forums,
        'idformation' => $idformation,
        'idUser' => $idUser,
    ]);
}

#[Route('/{idformation}/{idUser}/search', name: 'app_forum_search', methods: ['GET'])]
public function search(ForumRepository $forumRepository, int $idformation, int $idUser, Request $request): Response
{
    // Récupérer le titre à partir de la requête
    $titre = $request->query->get('titre');

    // Vérifier si un titre a été fourni dans la requête
    if ($titre) {
        // Si un titre a été fourni, effectuer la recherche par titre
        $forums = $forumRepository->rechercherParTitre($titre);
    } else {
        // Si aucun titre n'a été fourni, renvoyer une liste vide
        $forums = [];
    }

    return $this->render('forum/index.html.twig', [
        'forums' => $forums,
        'idformation' => $idformation,
        'idUser' => $idUser,
    ]);
}

    #[Route('/client/{idformation}/{idUser}', name: 'Front_forum_index', methods: ['GET'])]
public function indexFront(Request $request, ForumRepository $forumRepository, PaginatorInterface $paginator, int $idformation, int $idUser): Response
{
    // Récupérer tous les forums depuis la base de données
    $allForums = $forumRepository->findAll();

    // Paginer les forums avec KnpPaginatorBundle
    $forums = $paginator->paginate(
        $allForums, // Les données à paginer
        $request->query->getInt('page', 1), // Numéro de la page, par défaut 1
        3 // Nombre d'éléments par page
    );

    return $this->render('forum/indexFront.html.twig', [
        'forums' => $forums,
        'idformation' => $idformation,
        'idUser' => $idUser,
    ]);
}

    #[Route('/new/{idformation}/{idUser}', name: 'app_forum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $idformation, int $idUser): Response
    {
        $formation = $entityManager->getRepository(Formation::class)->find($idformation);

        if (!$formation) {
            throw $this->createNotFoundException('Formation not found');
        }

        $forum = new Forum();
        $forum->setIdformation($formation); // Set the Formation entity on the Forum entity
        $forum->setDateCreation(new \DateTime()); // Set current system date and time

        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($forum);
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_index', [
                'idformation' => $idformation,
                'idUser' => $idUser,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('forum/new.html.twig', [
            'forum' => $forum,
            'form' => $form,
            'idformation' => $idformation,
            'idUser' => $idUser,
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
