<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Offre;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\Persistence\ManagerRegistry;


#[Route('/formation')]
class FormationController extends AbstractController
{
    #[Route('/', name: 'app_formation_index', methods: ['GET'])]
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('base.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    #[Route('/back', name: 'app_formation_index3', methods: ['GET'])]
    public function index3(FormationRepository $formationRepository): Response
    {
        return $this->render('base2.html.twig', [
            
        ]);
    }
    #[Route('/formation/delete/{id}', name: 'delete_formation')]
    public function deleteFormation(ManagerRegistry $em, FormationRepository $formationRepository, $id): Response
    {
        $formation = $formationRepository->find($id);

        if (!$formation) {
            throw $this->createNotFoundException('Formation not found');
        }
        
        $em->getManager()->remove($formation);
        $em->getManager()->flush();

        return $this->redirectToRoute('app_formation_index2');
    }

    #[Route('/offre', name: 'showoffre', methods: ['GET'])]
    public function offre(): Response
    {
        $offres = $this->getDoctrine()->getRepository(Offre::class)->findAll();

        return $this->render('formation/offre.html.twig', [
            'offres' => $offres,
            
        ]);
    }
    #[Route('/formation', name: 'app_formation_index2', methods: ['GET'])]
    public function index2(EntityManagerInterface $entityManager): Response
    {
        $formation = new Formation();
        $formations = $entityManager->getRepository(Formation::class)->findAll();
        VarDumper::dump($formations, "This is the formations variable:");
        $form = $this->createForm(FormationType::class, $formation);

        return $this->render('formation/Formation.html.twig', [
            'formations' => $formations,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/formation/{id}', name: 'formation_details')]
    public function formationDetails(FormationRepository $formationRepository, $id): Response
    {
        // Fetch the formation details from the database based on the provided ID
        $formation = $formationRepository->find($id);
    
        // Render the template and pass the formation details as variables
        return $this->render('formation/meetingdetail.html.twig', [
            'formation' => $formation,
        ]);
    }



    #[Route('/edit/{id}', name: 'editFormation')]
    public function editLocation(EntityManagerInterface $em, Request $request, FormationRepository $lr, $id): Response
    {
        $formation = $lr->find($id);
    
        $oldImageUrl = $formation->getImageUrl(); // Store the old image URL
     
    
        $form = $this->createForm(FormationType::class, $formation);
    
        // Handle the form submission
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload if form is submitted
            $imageFile = $form->get('imageUrl')->getData();
           
    
            if ($imageFile) {
                try {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $imageFile->   guessExtension();
                    $newFilename = uniqid() . '.' . $extension;
    
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFilename
                    );
    
                    $formation->setImageUrl('/uploads/' . $newFilename);
    
                    // Delete old image if a new one is uploaded
                    if ($oldImageUrl) {
                        $oldImagePath = $this->getParameter('kernel.project_dir') . '/public' . $oldImageUrl;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                } catch (FileException $e) {
                    // Handle file upload error
                    $this->addFlash('error', 'Failed to upload image.');
                    return $this->redirectToRoute('editFormation', ['id' => $formation->getId()]);
                }
            }
    
            // Persist the changes to the database
            $em->flush();
    
            return $this->redirectToRoute('app_formation_index2');
        }
    
        // Render the form template
        return $this->render('formation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   

    

    
    #[Route('/add', name: 'app_formation_add')]
    public function addFormation(Request $request): Response
    {
        // Create a new instance of Formation entity
        $formation = new Formation();
      
        // Create the form using FormationType
        $form = $this->createForm(FormationType::class, $formation);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image file upload
            $imageFile = $form->get('imageUrl')->getData();
            

            if ($imageFile) {
                try {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $imageFile->getClientOriginalExtension();
                    $newFilename = uniqid() . '.' . $extension;

                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFilename
                    );

                    $formation->setImageUrl('/uploads/' . $newFilename);
                } catch (\Exception $e) {
                    // Handle file upload error
                    $this->addFlash('error', 'Failed to upload image.');
                    return $this->redirectToRoute('app_formation_add');
                }
            }

            // Persist the Formation entity
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            // Redirect to the formation index page
            $this->addFlash('success', 'Formation added successfully.');
            return $this->redirectToRoute('app_formation_index2');
        }

        // Render the form template
        return $this->render('formation/add_formation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

