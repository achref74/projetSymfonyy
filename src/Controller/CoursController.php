<?php

namespace App\Controller;
use App\Entity\Evaluation;
use App\Entity\Cours;
use App\Form\Cours1Type;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/cours')]
class CoursController extends AbstractController
{
    #[Route('/', name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new/{idFormation}', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,int $idFormation): Response
    {
        $cour = new Cours();
        $cour -> setIdFormation($idFormation);
        $form = $this->createForm(Cours1Type::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ressourceFile = $form->get('ressource')->getData();
            $imageFile = $form->get('image')->getData();

            if ($ressourceFile) {
                $ressourceFileName = uniqid() . '.' . $ressourceFile->guessExtension();

                try {
                    $ressourceFile->move(
                        $this->getParameter('ressource_directory'),
                        $ressourceFileName
                    );
                } catch (FileException $e) {
                    // Handle error
                }

                $cour->setRessource($ressourceFileName);
            }

            if ($imageFile) {
                $imageFileName = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('video_directory'),
                        $imageFileName
                    );
                } catch (FileException $e) {
                    // Handle error
                }

                $cour->setImage($imageFileName);
            }
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show( EntityManagerInterface $entityManager,Cours $cour): Response
    {
        $evaluation = $entityManager->getRepository(Evaluation::class)->findOneBy(['cours' => $cour->getId()]);
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
            'evaluation'=>$evaluation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Cours1Type::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
