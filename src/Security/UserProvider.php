<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByIdentifier($identifier): UserInterface
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $identifier]);
    
        if (!$user) {
            throw new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
        }
    
        // Assurez-vous que $user est une instance de UserInterface
        if (!$user instanceof UserInterface) {
            throw new \RuntimeException('User must implement UserInterface.');
        }
    
        return $user;
    }
    

    public function loadUserByUsername($username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new \InvalidArgumentException('Invalid user class.');
        }

        $refreshedUser = $this->entityManager->getRepository(User::class)->find($user->getIdUser());

        if (!$refreshedUser) {
            throw new UserNotFoundException(sprintf('User with ID "%s" not found.', $user->getId()));
        }

        return $refreshedUser;
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}