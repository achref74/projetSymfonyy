<?php

namespace App\Security;
use Twilio\Rest\Client;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    private EntityManagerInterface $entityManager;
    private UrlGeneratorInterface $urlGenerator;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;

    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user || !$user->getActivated()) {
            throw new AuthenticationException('Account not activated.');
        }

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }
    function generateOTP(int $length = 6): string
    {
        $otp = '';
        $characters = '0123456789';
        $charLength = strlen($characters);
        
        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[rand(0, $charLength - 1)];
        }
        
        return $otp;
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Retrieve the user from the token
        $user = $token->getUser();

        // Get the user ID and role
        $userId = $user->getIdUser();
        $userRole = $user->getRole();
        $user = $this->userRepository->find($userId);


        //Check if the user ID is valid
        // if ($userId) {
        //     if ($userRole == 2) {
        //         return new RedirectResponse($this->urlGenerator->generate('user_home_back', ['idUser' => $userId]));
        //     } else {
        //         return new RedirectResponse($this->urlGenerator->generate('user_home_front', ['idUser' => $userId]));
        //     }
        // }



        // If the user is not recognized, you can redirect elsewhere

        // Generate OTP code
        $otpCode = $this->generateOTP();
        $user->setOtp($otpCode);
        
        $this->entityManager->flush();
        $clientNumber = "+216" . strval($user->getNumtel());
        
        // Send OTP via Twilio SMS
        $this->sendOTPviaSMS($clientNumber, $otpCode,$token);

        

    
        // // Redirect user to OTP verification page

        // // Check if the user ID is valid
        // return new RedirectResponse($this->urlGenerator->generate('verify_otp'));
        
        return new RedirectResponse($this->urlGenerator->generate('verify_otp', ['userId' => $userId]));

    }

    function sendOTPviaSMS(string $phoneNumber, string $otp, TokenInterface $token): void
{
    // Initialize Twilio client
    $twilioSid ="";

    $twilioToken="";

    $twilio = new Client($twilioSid, $twilioToken);

    // Send SMS
    $message = $twilio->messages
        ->create(
            '+21624954442', // to
            [
                "from" => "+18149850317",
                "body" => "Your OTP is: " . $otp
            ]
        );

    // Store OTP in session
    $user = $token->getUser();
    if ($user instanceof UserInterface) {
        $user->setOtp($otp); // Assuming your User entity has a setOtp() method
    }
}

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    public function onLogoutSuccess(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
