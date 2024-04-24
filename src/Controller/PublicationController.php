<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\formation;
use App\Entity\Forum;
use App\Entity\User;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/publication')]
class PublicationController extends AbstractController
{
    #[Route('/{idUser}/{idForum}/{idformation}', name: 'app_publication_index', methods: ['GET'])]
public function index(Request $request, PaginatorInterface $paginator, PublicationRepository $publicationRepository, int $idUser, int $idForum, int $idformation): Response
{
    // Retrieve all publications based on $idForum
    $publicationsQuery = $publicationRepository->createQueryBuilder('p')
        ->where('p.idforum = :idforum')
        ->setParameter('idforum', $idForum)
        ->getQuery();

    // Paginate the publications
    $publications = $paginator->paginate(
        $publicationsQuery, // Query to paginate
        $request->query->getInt('page', 1), // Current page number, 1 by default
        3 // Number of items per page
    );

    return $this->render('publication/index.html.twig', [
        'publications' => $publications,
        'idUser' => $idUser,
        'idForum' => $idForum,
        'idformation' => $idformation,
    ]);
}
    #[Route('/Back/{idUser}/{idForum}/{idformation}', name: 'Back_publication_index', methods: ['GET'])]
    public function indexBack(PublicationRepository $publicationRepository, int $idUser, int $idForum, int $idformation): Response
    {
        // Retrieve publications based on $idForum
        $publications = $publicationRepository->findBy(['idforum' => $idForum]);
    
        return $this->render('publication/indexBack.html.twig', [
            'publications' => $publications,
            'idUser' => $idUser,
            'idForum' => $idForum,
            'idformation' => $idformation,
        ]);
    }
    


    #[Route('/new/Client/{idUser}/{idForum}/{idformation}', name: 'app_publication_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $idUser, int $idForum, int $idformation): Response
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
        $publication->setDateCreation(new \DateTime());

        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier image
            $imageFile = $form->get('image')->getData();

            // Vérifier s'il y a un fichier uploadé
            if ($imageFile) {
                // Définir un nouveau nom de fichier pour éviter les collisions
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                // Déplacer le fichier dans le dossier public/uploads
                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'erreur, par exemple, afficher un message ou rediriger avec une erreur
                }

                // Mettre à jour le champ image de la publication avec le nom du fichier
                $publication->setImage($newFilename);
            }

            // Enregistrer la publication dans la base de données
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [
                'idUser' => $idUser,
                'idForum' => $idForum,
                'idformation' => $idformation,
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form,
            'idUser' => $idUser,
            'idForum' => $idForum,
            'idformation' => $idformation,
        ]);
    }
    
    #[Route('/{idp}/edit/{idUser}/{idForum}/{idformation}', name: 'app_publication_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager, int $idformation, int $idUser, int $idForum): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier image
            $imageFile = $form->get('image')->getData();
    
            // Vérifier s'il y a un fichier uploadé
            if ($imageFile) {
                // Définir un nouveau nom de fichier pour éviter les collisions
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                // Déplacer le fichier dans le dossier public/uploads
                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'erreur, par exemple, afficher un message ou rediriger avec une erreur
                }
    
                // Mettre à jour le champ image de la publication avec le nom du fichier
                $publication->setImage($newFilename);
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_publication_index', [
                'idUser' => $idUser,
                'idForum' => $idForum,
                'idformation' => $idformation,
            ], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form,
            'idUser' => $idUser,
            'idForum' => $idForum,
            'idformation' => $idformation,
        ]);
    }
    

    #[Route('/{idUser}/{idForum}/{idformation}/delete/Client/{idp}', name: 'app_publication_delete', methods: ['POST'])]
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager,int $idUser,int $idForum, int $idformation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getIdp(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publication_index', ['idUser' => $idUser,
        'idForum' => $idForum,'idformation' => $idformation,], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{idUser}/{idForum}/{idformation}/delete/Back/{idp}', name: 'Back_publication_delete', methods: ['POST'])]
    public function deleteBack(Request $request, Publication $publication, EntityManagerInterface $entityManager,int $idUser,int $idForum, int $idformation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getIdp(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Back_publication_index', ['idUser' => $idUser,
        'idForum' => $idForum,'idformation' => $idformation,], Response::HTTP_SEE_OTHER);
    }
}
