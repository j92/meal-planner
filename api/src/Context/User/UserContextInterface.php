<?php
declare(strict_types=1);

namespace App\Context\User;

use App\Entity\User;

interface UserContextInterface
{
    /**
     * @throws UserNotFound
     */
    public function getUser(): User;
}
