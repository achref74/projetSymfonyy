<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OTPController extends AbstractController
{
    private $tokenStorage;
    private $authenticationManager;
    private UrlGeneratorInterface $urlGenerator;


    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager,UrlGeneratorInterface $urlGenerator)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
        $this->urlGenerator = $urlGenerator;

    }

    public function verifyOTP(Request $request, $userId): Response
    {
        // Fetch user based on $userId
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);

        // Handle form submission
        // Check if submitted OTP matches stored OTP
        if ($request->isMethod('POST')) {
            $submittedOTP = $request->request->get('otp');
            $storedOTP = $user->getOtp();
            if ($submittedOTP === $storedOTP) {
                // OTP matched, proceed with login
                try {
                    // Create a token for the authenticated user
                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());

                    // Authenticate the user
                    $authenticatedToken = $this->authenticationManager->authenticate($token);

                    // Store the authenticated token
                    $this->tokenStorage->setToken($authenticatedToken);
                    $userRole=$user->getRole();
                    // Redirect the user after successful authentication
        if ($userId) {
            if ($userRole == 2) {
                return new RedirectResponse($this->urlGenerator->generate('user_home_back', ['idUser' => $userId]));
            } else {
                return new RedirectResponse($this->urlGenerator->generate('user_home_front', ['idUser' => $userId]));
            }
        }
                    
                } catch (AuthenticationException $exception) {
                    return $this->redirectToRoute('app_login');
                }
            } else {
                return $this->redirectToRoute('app_logout');
            }
        }

        // Render OTP verification form
        return $this->render('security/checkOtp.html.twig');
    }
}
