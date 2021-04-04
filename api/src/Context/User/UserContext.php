<?php
declare(strict_types=1);

namespace App\Context\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

final class UserContext implements UserContextInterface
{
    private Security $security;
    private UserRepository $users;

    public function __construct(
        Security $security,
        UserRepository $users
    ) {
        $this->security = $security;
        $this->users = $users;
    }

    public function getUser(): User
    {
        $loggedInUser = $this->security->getUser();

        if (!$loggedInUser) {
            throw new UserNotFound();
        }

        $user = $this->users->findOneBy(['username' => $loggedInUser->getUsername()]);

        if ($user === null) {
            throw new UserNotFound();
        }

        return $user;
    }
}
