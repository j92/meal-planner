<?php
declare(strict_types=1);

namespace App\Context\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

final class StaticUserContext implements UserContextInterface
{
    private UserRepository $users;

    private EntityManagerInterface $em;

    public function __construct(
        UserRepository $users,
        EntityManagerInterface $em
    ) {
        $this->users = $users;
        $this->em = $em;
    }

    public function getUser(): User
    {
        $user = $this->users->findOneBy(['username' => 'joost']);

        if ($user === null) {
            $user = new User();
            $user->setUsername('joost');
            $user->setCreatedAt(new \DateTime());
            $user->setEmail('joostvdriel@gmail.com');
            $user->setPassword('secret');

            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }
}
