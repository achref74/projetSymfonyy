<?php

namespace App\Controller;
use App\Repository\OffreRepository;

use App\Entity\Formation;
use App\Entity\Offre;
use App\Form\FormationType;
use App\Form\OffreType;
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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;

#[Route('/formation')]
class FormationController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_formation_index', methods: ['GET'])]
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('base.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    #[Route('/back', name: 'app_formation_back', methods: ['GET'])]
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
    public function index2(EntityManagerInterface $entityManager,Request $request, PaginatorInterface $paginator): Response
    {
        $twoDaysBefore = new \DateTime();
        $twoDaysBefore->modify('+2 days');
        $targetDate = new \DateTime();
        $targetDate->modify('+2 days');


        $formations = $this->entityManager
            ->getRepository(Offre::class)
            ->createQueryBuilder('f')
            ->where('f.dateF = :date')
            ->setParameter('date', $targetDate->format('Y-m-d'))
            ->getQuery()
            ->getResult();

            $formationNames = [];
        if($formations){
            foreach ($formations as $formation) {
                $formationNames[] = $formation->getDescription();
            }
            
            $concatenatedNames = implode(", ", $formationNames);
        // Do something with $formations, like logging or sending notifications.
        $transport = Transport::fromDsn('smtp://api:628e6781c06dae54e0a5c75db7ade8de@live.smtp.mailtrap.io:587');

        $mailer = new Mailer($transport);
        //BUNDLE MAILER
        $email = (new Email())
        ->from('mailtrap@demomailtrap.com')
        ->to('yasminebousselmi5t@gmail.com')
        ->subject('Foramations disponible')
        ->html("<p>Bonjour,</p><p>Les formations suivantes exipre dans moins de 2 jours,  : <a>$concatenatedNames</a></p>");

        // Send mail
        $mailer->send($email);}
    
    

        //--------------------------------------------

        $todayDate = new \DateTime();
        $todayDate->setTime(0, 0, 0); // Set time to midnight
        $todayDate->format('Y-m-d');

        $formations = $entityManager->getRepository(Formation::class)->findAll();
        $offers = [];
        foreach ($formations as $formation) {
            $formationdatefString = $formation->getDatef()->format('Y-m-d'); // Format date to string
            $formationdatef = new \DateTime($formationdatefString); // Create a new DateTime object
            $formationdatef->setTime(0, 0, 0); // Set time to midnight
            if($formationdatef == $todayDate){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($formation);
                $entityManager->flush();   
         
            }else{
            // Fetch corresponding offers for each formation
            $offers[$formation->getIdFormation()] = $entityManager->getRepository(Offre::class)->findBy(['formation' => $formation]);
        }
    }
    $formations = $entityManager->getRepository(Formation::class)->findAll();
foreach($formations as $formation){
    $offers[$formation->getIdFormation()] = $entityManager->getRepository(Offre::class)->findBy(['formation' => $formation]);

}

        $form = $this->createForm(FormationType::class, $formation);

        $formations = $paginator->paginate(
            $formations, 
            $request->query->getInt('page', 1),
            3
        );


        return $this->render('formation/Formation.html.twig', [
            'formations' => $formations,
            'form' => $form->createView(),
            'offers' => $offers,

        ]);
    }
    #[Route('/formationOffre', name: 'app_formation_index3', methods: ['GET'])]
    public function OffreFormation(FormationRepository $formationRepository, OffreRepository $offreRepository): Response
    {
        $formations = $formationRepository->findAll();
        $offers = [];
    
        foreach ($formations as $formation) {
            $offers[$formation->getIdFormation()] = $offreRepository->findBy(['formation' => $formation]);
        }
    
        return $this->render('formation/offreFormation.html.twig', [
            'formations' => $formations,
            'offers' => $offers,
        ]);
    }

     /**
     * @Route("/display-offers", name="display_offers")
     */
    public function displayOffers(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $offers = $entityManager->getRepository(Offre::class)->findAll();
        $todayDate = new \DateTime();
        $todayDate->format('Y-m-d');
        $todayDate->setTime(0, 0, 0); // Set time to midnight

        foreach ($offers as $offer) {
            $formationdatefString = $offer->getDateF()->format('Y-m-d'); // Format date to string
            $offerdatef = new \DateTime($formationdatefString); // Create a new DateTime object
            $offerdatef->setTime(0, 0, 0); // Set time to midnight
            if($offerdatef == $todayDate){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($offer);
                $entityManager->flush();   
            }
        }

        // Retrieve all offers from the database
        $offers = $entityManager->getRepository(Offre::class)->findAll();

        // Retrieve all formations from the database
        $formations = $entityManager->getRepository(Formation::class)->findAll();

        // Assuming you have a method to associate offers with their respective formations
        $formationsWithOffers = [];

        foreach ($formations as $formation) {
            $offersForFormation = [];

            foreach ($offers as $offer) {
                // Check if the offer belongs to the current formation
                if ($offer->getFormation() === $formation) {
                    $offersForFormation[] = $offer;
                }
            }

            // Store the formation and its associated offers
            $formationsWithOffers[] = [
                'formation' => $formation,
                'offers' => $offersForFormation,
            ];
        }

        // Render the template with the data
        return $this->render('formation/display_offers.html.twig', [
            'formationsWithOffers' => $formationsWithOffers,
            'todayd'=>$todayDate

        ]);
    }
     /**
     * @Route("/offer/update/{id}", name="update_offer")
     */
    public function updateOffer(Request $request, Offre $offer): Response
    {
        $form = $this->createForm(OffreType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('display_offers'); // Adjust the route name as needed
        }

        return $this->render('offre/update.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/offer/delete/{id}", name="delete_offer", methods={"POST"})
     */
    public function deleteOffer(Request $request, Offre $offer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getIdOffre(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('display_offers'); // Adjust the route name as needed
    }
    

    #[Route('/formation/{id}', name: 'formation_details')]
    public function formationDetails(FormationRepository $formationRepository, $id): Response
    {
        $todayDate = new \DateTime();
        $todayDate->format('Y-m-d');
        // Fetch the formation details from the database based on the provided ID
        $formation = $formationRepository->find($id);
        $formationdatef= $formation->getDatef()->format('Y-m-d');

        // Render the template and pass the formation details as variables
        return $this->render('formation/meetingdetail.html.twig', [
            'formation' => $formation,
            'today'=>$todayDate,
            'todayf'=>$formationdatef

        ]);
    }

    #[Route('/formation/{id}/create-offer', name: 'create_offer')]
    public function createOffer(Request $request, $id): Response
    {
        // Fetch the formation based on the provided ID
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
        

        // Create a new instance of the Offre entity
        $offer = new Offre();

        // Handle form submission
        $form = $this->createForm(OffreType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the formation for the offer
            $offer->setFormation($formation);

            // Persist the offer to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            // Redirect to the formation details page
            return $this->redirectToRoute('formation_details', ['id' => $id]);
        }

        // Render the form for creating an offer
        return $this->render('formation/create_offer.html.twig', [
            'form' => $form->createView(),
            'formation' => $formation,
        ]);
    }



    #[Route('/edit/{id}', name: 'editFormation')]
    public function editFormation(EntityManagerInterface $entityManager, Request $request, Formation $formation): Response

    {
        
        $oldImageUrl = $formation->getImageUrl(); // Store the old image URL

        $form = $this->createForm(FormationType::class, $formation);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload if form is submitted
            $imageFile = $form->get('imageUrl')->getData();
            

            if ($imageFile !== null){
                try {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $imageFile->getClientOriginalExtension();
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
            } else {
                // If $imageFile is null, set image URL to the old image path
                $formation->setImageUrl($oldImageUrl);
            }
            

            // Persist changes to the database
            $entityManager->flush();

            $this->addFlash('success', 'Formation updated successfully.');

            return $this->redirectToRoute('app_formation_index2');
        }

        return $this->render('formation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
       
    }
     /**
     * @Route("/formationsback", name="formation_backend")
     */
    public function backformation(Request $request, FormationRepository $formationRepository): Response
{
    $searchTerm = $request->query->get('search'); // Get search term from query parameters
    $formations = [];

    if ($searchTerm) {
        $formations = $formationRepository->findBySearchTerm($searchTerm);
    } else {
        $formations = $formationRepository->findAll();
    }

    return $this->render('backformation.html.twig', [
        'formations' => $formations,
        'searchTerm' => $searchTerm, // Pass the search term to the template for display
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

