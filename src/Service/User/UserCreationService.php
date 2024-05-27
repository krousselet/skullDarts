<?php

namespace App\Service\User;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreationService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function registerUser(Utilisateur $user, array $formData): void
    {
        $now = new \DateTimeImmutable();

        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $formData['plainPassword']
            )
        );
        $user->setCreation($now);
        $user->setModification($now);
        $user->setNom($formData['nom']);
        $user->setPrenom($formData['prenom']);
        $user->setTelephone($formData['telephone']);
        if($formData['email'] === $_ENV['APP_DEV_EMAIL']) {
            $user->setRoles(['ROLE_ADMIN']);
        }else {
            $user->setEmail($formData['email']);
        }
        $user->setTelephone($formData['email']);
        $user->setAgreed(true);
        $user->setVerified(false);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}