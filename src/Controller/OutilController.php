<?php

namespace App\Controller;

use App\Entity\Outil;
use App\Form\OutilType;
use App\Repository\OutilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


#[Route('/outil')]
class OutilController extends AbstractController
{
    #[Route('/', name: 'app_outil_index', methods: ['GET'])]
    public function index(Request $request,OutilRepository $outilRepository, PaginatorInterface $paginator): Response
    {
          // Récupère tous les travaux depuis la base de données
          $allTravaux = $outilRepository->findAll();
            // Paginer les travaux avec KnpPaginatorBundle
        $travaux = $paginator->paginate(
            $allTravaux, // Les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page, par défaut 1
            10 // Nombre d'éléments par page
        );
        return $this->render('outil/index.html.twig', [
            'outils' => $travaux,
        ]);
    }




    #[Route('/front', name: 'app_outil_indexFront', methods: ['GET'])]
    public function indexFront(OutilRepository $outilRepository): Response
    {
        return $this->render('outil/indexFront.html.twig', [
            'outils' => $outilRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_outil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $outil = new Outil();
        $form = $this->createForm(OutilType::class, $outil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $outil->setImage($newFilename);
            }
            $entityManager->persist($outil);
            $entityManager->flush();

            return $this->redirectToRoute('app_outil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('outil/new.html.twig', [
            'outil' => $outil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_outil_show', methods: ['GET'])]
    public function show(Outil $outil): Response
    {
        return $this->render('outil/show.html.twig', [
            'outil' => $outil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_outil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Outil $outil, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OutilType::class, $outil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_outil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('outil/edit.html.twig', [
            'outil' => $outil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_outil_delete', methods: ['POST'])]
    public function delete(Request $request, Outil $outil, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$outil->getId(), $request->request->get('_token'))) {
            $entityManager->remove($outil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_outil_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/', name: 'outils_prix')]
    public function dossiersByEtat(OutilRepository $outilRepository): Response
    {
        $outils = $outilRepository->findBy(
            [], // Aucun critère de recherche spécifié, donc tous les outils seront retournés
            ['prix' => 'ASC'] // Trier par prix croissant
        );
    
        return $this->render('outil/index.html.twig', [
            'outils' => $outils,
        ]);
    }
    
    
}
