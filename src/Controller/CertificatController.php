<?php

namespace App\Controller;

use App\Entity\Certificat;
use App\Entity\Formation;
use App\Form\CertificatType;
use App\Repository\CertificatRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

#[Route('/certificat')]
class CertificatController extends AbstractController
{
    #[Route('/', name: 'app_certificat_index', methods: ['GET'])]
    public function index(CertificatRepository $certificatRepository): Response
    {
        return $this->render('certificat/index.html.twig', [
            'certificats' => $certificatRepository->findAll(),
        ]);
    }

    #[Route('/new/{idFormation}', name: 'app_certificat_new_formation', methods: ['GET', 'POST'])]
    public function new_certif_formation(Request $request, EntityManagerInterface $entityManager,$idFormation,Pdf $knpSnappyPdf): Response
    {
             // Fetch the Formation entity by its ID
             $formation = $entityManager->getRepository(Formation::class)->find($idFormation);

             // Check if Formation exists
             if (!$formation) {
                 throw $this->createNotFoundException('Formation not found');
             }
     
             // Create a new Certificat entity
             $certificat = new Certificat();
     
             // Set Certificat properties from Formation entity
             $certificat->setTitre($formation->getNom());
             $certificat->setDescription($formation->getDescription());
     
             // Set the dateObtention property to the current system date
             $dateObtention = new \DateTime();
             $certificat->setDateObtention($dateObtention);
     
             // Set the Formation for the Certificat
             $certificat->setIdformation($formation);
     
             // Save the Certificat entity
             $entityManager->persist($certificat);
             $entityManager->flush();
     
             // Render certificat.html.twig with the Certificat entity
            //  $html = $this->renderView('certificat/certificat.html.twig', array(
            //     'certificat'  => $certificat
            // ));
            //  return new PdfResponse(
            //     $knpSnappyPdf->getOutput($html),
            //     'file.pdf'
            // );
            return new PdfResponse(
                $knpSnappyPdf->generateFromHtml(
                $this->renderView(
                    'certificat/certificat.html.twig',
                    array(
                        'certificat'  => $certificat
                    )
                ),
                'C:/Users/Secondary/Desktop/output.pdf'
            ));
    }
    #[Route('/new', name: 'app_certificat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $certificat = new Certificat();
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($certificat);
            $entityManager->flush();

            return $this->redirectToRoute('app_certificat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificat/new.html.twig', [
            'certificat' => $certificat,
            'form' => $form,
        ]);
    }

    #[Route('/{idCertificat}', name: 'app_certificat_show', methods: ['GET'])]
    public function show(Certificat $certificat): Response
    {
        return $this->render('certificat/show.html.twig', [
            'certificat' => $certificat,
        ]);
    }

    #[Route('/{idCertificat}/edit', name: 'app_certificat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Certificat $certificat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CertificatType::class, $certificat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_certificat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificat/edit.html.twig', [
            'certificat' => $certificat,
            'form' => $form,
        ]);
    }

    #[Route('/{idCertificat}', name: 'app_certificat_delete', methods: ['POST'])]
    public function delete(Request $request, Certificat $certificat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certificat->getIdCertificat(), $request->request->get('_token'))) {
            $entityManager->remove($certificat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_certificat_index', [], Response::HTTP_SEE_OTHER);
    }
}
