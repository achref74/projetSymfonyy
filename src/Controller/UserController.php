<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\UserAdditionalInfoType;
use App\Form\ClientAdditionalInfoType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;




#[Route('/user')]
class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;

    }
    
    #[Route('/homeFront', name: 'user_home_front', methods: ['GET'])]
    public function indexFront(): Response
    {
        return $this->render('user/homeFront.html.twig');
    }

    #[Route('/homeBack', name: 'user_home_back', methods: ['GET'])]
    public function indexBack(): Response
    {
        return $this->render('user/homeBack.html.twig');
    }
    
    #[Route('/app_user_index', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        // Récupérer tous les utilisateurs depuis le repository
        $users = $userRepository->findAll();
    
        // Parcourir tous les utilisateurs pour mettre à jour le chemin de l'image
        foreach ($users as $user) {
            // Récupérer le chemin de l'image complet depuis l'entité User
            $imagePathFromDatabase = $user->getImageProfil();
            $imagePathFromDatabase1 = $user->getCv();

            
            // Extraire le nom du fichier de l'ancien chemin
            $imageName = basename($imagePathFromDatabase);
            $imageName1 = basename($imagePathFromDatabase1);

            
            // Construire le nouveau chemin de l'image avec le nouveau nom de fichier
            $newImagePath = '/images/' . $imageName;
            $newImagePath1 = '/images/' . $imageName1;

            
            // Mettre à jour le chemin de l'image dans l'entité User
            $user->setImageProfil($newImagePath);
            $user->setCv($newImagePath1);

        }
    
        // Retourner la réponse avec les utilisateurs mis à jour
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $userData = $request->getSession()->get('userData', []);
        
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
    
        // Gérer la requête
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $user = $form->getData();
            
            // Vérifier si le choix est égal à 1 pour Formateur
            $roleChoice = $form->get('role')->getData();
            if ($roleChoice === 1) {
                $user->setRole(1);
            } else {
                $user->setRole(0);
            }
            
            // Vérifier et définir le numéro de téléphone
            if ($form->has('numtel')) {
                $numtel = $form->get('numtel')->getData();
                if ($numtel !== null) {
                    $user->setNumtel((int) $numtel);
                }
            }
    
            // Enregistrer les données utilisateur dans la session
            $request->getSession()->set('userData', [
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'dateNaissance' => $user->getDateNaissance()->format('Y-m-d'), // Formatage de la date pour éviter les problèmes de session
                'adresse' => $user->getAdresse(),
                'numtel' => $user->getNumtel(),
                'genre' => $user->getGenre(),
                'role' => $user->getRole(),
            ]);
    
            // Rediriger en fonction du rôle sélectionné
            if ($user->getRole() === 0) {
                // Si le rôle est client
                return $this->redirectToRoute('client_additional_info');
            } else {
                // Si le rôle est formateur
                return $this->redirectToRoute('app_user_additional_info');
            }
        }
        
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
   
    #[Route('/additional-info', name: 'app_user_additional_info', methods: ['GET', 'POST'])]
public function additionalInfo(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, SluggerInterface $slugger): Response
{
    $userData = $request->getSession()->get('userData', []);
    
    $user = new User();
    $user->setNom($userData['nom'] ?? '');
    $user->setPrenom($userData['prenom'] ?? '');
    $user->setEmail($userData['email'] ?? '');
    $dateNaissance = isset($userData['dateNaissance']) ? new \DateTime($userData['dateNaissance']) : new \DateTime('');
    $user->setDateNaissance($dateNaissance);
    $user->setAdresse($userData['adresse'] ?? '');
    $user->setNumtel(isset($userData['numtel']) ? (int) $userData['numtel'] : 0);
    $user->setRole(isset($userData['role']) ? (int) $userData['role'] : 1);
    
    $form = $this->createForm(UserAdditionalInfoType::class, $user);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $plainPassword = $user->getMdp();
        if ($plainPassword !== null) {
            $hashedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
            // Assurez-vous que votre entité User a une méthode setPassword() pour définir le mot de passe haché
            $user->setMdp($hashedPassword);
        }
        $imageFile = $form->get('imageProfil')->getData();
        if ($imageFile instanceof UploadedFile) {
            // Déplacer le fichier vers le répertoire de destination sans changer son nom
            try {
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/images',
                    $imageFile->getClientOriginalName()
                );
                // Mettre à jour le chemin complet de l'image dans l'entité User
                $user->setImageProfil('/images/' . $imageFile->getClientOriginalName());
            } catch (FileException $e) {
                // Gérer l'exception si le déplacement du fichier a échoué
                // Par exemple, enregistrer le message d'erreur dans les logs
            }
        }
        $imageFile1 = $form->get('cv')->getData();
        if ($imageFile1 instanceof UploadedFile) {
            // Déplacer le fichier vers le répertoire de destination sans changer son nom
            try {
                $imageFile1->move(
                    $this->getParameter('kernel.project_dir') . '/public/images',
                    $imageFile1->getClientOriginalName()
                );
                // Mettre à jour le chemin complet de l'image dans l'entité User
                $user->setCv('/images/' . $imageFile1->getClientOriginalName());
            } catch (FileException $e) {
                // Gérer l'exception si le déplacement du fichier a échoué
                // Par exemple, enregistrer le message d'erreur dans les logs
            }
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }

    
    return $this->render('user/additional_info.html.twig', [
        'form' => $form->createView(),
    ]);
}


#[Route('/client-additional-info', name: 'client_additional_info', methods: ['GET', 'POST'])]
public function clientAdditionalInfo(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
{
    $userData = $request->getSession()->get('userData', []);

    $user = new User();
    $user->setNom($userData['nom'] ?? '');
    $user->setPrenom($userData['prenom'] ?? '');
    $user->setEmail($userData['email'] ?? '');
    $dateNaissance = isset($userData['dateNaissance']) ? new \DateTime($userData['dateNaissance']) : new \DateTime('');
    $user->setDateNaissance($dateNaissance);
    $user->setAdresse($userData['adresse'] ?? '');
    $user->setNumtel(isset($userData['numtel']) ? (int) $userData['numtel'] : 0);
    $user->setRole(isset($userData['role']) ? (int) $userData['role'] : 0);
    
    $form = $this->createForm(ClientAdditionalInfoType::class, $user);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
           // Hachage du mot de passe avec l'algorithme par défaut de Symfony
           $plainPassword = $user->getMdp();
           if ($plainPassword !== null) {
               $hashedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
               // Assurez-vous que votre entité User a une méthode setPassword() pour définir le mot de passe haché
               $user->setMdp($hashedPassword);
           }
        $imageFile = $form->get('imageProfil')->getData();
        if ($imageFile instanceof UploadedFile) {
            // Déplacer le fichier vers le répertoire de destination sans changer son nom
            try {
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/images',
                    $imageFile->getClientOriginalName()
                );
                // Mettre à jour le chemin complet de l'image dans l'entité User
                $user->setImageProfil('/images/' . $imageFile->getClientOriginalName());
            } catch (FileException $e) {
                // Gérer l'exception si le déplacement du fichier a échoué
                // Par exemple, enregistrer le message d'erreur dans les logs
            }
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }
    
    return $this->render('user/client_additional_info.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/{idUser}', name: 'app_user_show', methods: ['GET', 'POST'])]
    public function show(Request $request, User $user): Response
    {
        // Créer le formulaire de modification
        $editForm = $this->createForm(UserType::class, $user);
        $editForm->handleRequest($request);

        // Si le formulaire de modification est soumis et valide
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // Rediriger vers la même page après la modification
            return $this->redirectToRoute('app_user_show', ['idUser' => $user->getIdUser()]);
        }

        // Déterminer le template à utiliser en fonction du rôle de l'utilisateur
        $template = $user->getSpecialite() !== null ? 'user/show_formateur.html.twig' : 'user/show_client.html.twig';

        // Afficher le profil avec le formulaire de modification
        return $this->render($template, [
            'user' => $user,
            'editForm' => $editForm->createView(),
        ]);
    }

    
    #[Route('/{idUser}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIdUser(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
    
    
    #[Route('/{idUser}/edit', name: 'app_user_edit_formateur', methods: ['GET', 'POST'])]
public function editFormateur(Request $request, User $user): Response
{
    // Vérifier si la requête est de type POST (l'utilisateur a soumis le formulaire de modification)
    if ($request->isMethod('POST')) {
        // Récupérer les données envoyées par le formulaire
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $dateNaissance = $request->request->get('dateNaissance');
        $adresse = $request->request->get('adresse');
        $numtel = $request->request->get('numtel');
        $specialite = $request->request->get('specialite');
        $niveauAcademique = $request->request->get('niveauAcademique');
        $disponiblite = $request->request->get('disponiblite');
        $cv = $request->request->get('cv');
        
        // Mettre à jour les propriétés de l'utilisateur
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setEmail($email);
        $user->setDateNaissance(new \DateTime($dateNaissance));
        $user->setAdresse($adresse);
        $user->setNumtel($numtel);
        $user->setSpecialite($specialite);
        $user->setNiveauAcademique($niveauAcademique);
        $user->setDisponiblite($disponiblite);
        $user->setCv($cv);

        // Enregistrer les modifications dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        // Rediriger vers la page de profil de l'utilisateur
        return $this->redirectToRoute('app_user_show', ['idUser' => $user->getIdUser()]);
    }

    // Si la requête n'est pas de type POST, afficher le formulaire de modification du formateur
    return $this->render('user/edit_formateur.html.twig', [
        'user' => $user,
    ]);
}


#[Route('/{idUser}/editClient', name: 'app_user_edit_client', methods: ['GET', 'POST'])]
public function editClient(Request $request, User $user): Response
{
    // Vérifier si la requête est de type POST (l'utilisateur a soumis le formulaire de modification)
    if ($request->isMethod('POST')) {
        // Récupérer les données envoyées par le formulaire
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $dateNaissance = $request->request->get('dateNaissance');
        $adresse = $request->request->get('adresse');
        $numtel = $request->request->get('numtel');
        $niveauScolaire = $request->request->get('niveauScolaire');
        
        // Mettre à jour les propriétés de l'utilisateur
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setEmail($email);
        $user->setDateNaissance(new \DateTime($dateNaissance));
        $user->setAdresse($adresse);
        $user->setNumtel($numtel);
        $user->setNiveauScolaire($niveauScolaire);

        // Enregistrer les modifications dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        // Rediriger vers la page de profil de l'utilisateur
        return $this->redirectToRoute('app_user_show', ['idUser' => $user->getIdUser()]);
    }

    // Si la requête n'est pas de type POST, afficher le formulaire de modification du client
    return $this->render('user/edit_client.html.twig', [
        'user' => $user,
    ]);
}
}   
