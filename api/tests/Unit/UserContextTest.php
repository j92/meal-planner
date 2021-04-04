<?php
declare(strict_types=1);

namespace App\Tests\Unit\Context;

use App\Context\User\UserContext;
use App\Context\User\UserNotFound;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\User;
use function PHPUnit\Framework\assertEquals;

class UserContextTest extends TestCase
{
    public function testCanGetTheLoggedInUser(): void
    {
        $security = $this->createConfiguredMock(Security::class, ['getUser' => new User('test@example.com', 'secret')]);

        $user = new \App\Entity\User();
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['username' => 'test@example.com'])
            ->willReturn($user);

        $context = new UserContext(
            $security,
            $userRepository
        );

        assertEquals($user, $context->getUser());
    }

    public function testHandlesUserThatIsNotLogged(): void
    {
        $security = $this->createConfiguredMock(Security::class, ['getUser' => null]);

        $context = new UserContext(
            $security,
            $this->createMock(UserRepository::class)
        );

        $this->expectException(UserNotFound::class);

        $context->getUser();
    }

    public function testHandlesNonExistingLoggedInUser(): void
    {
        $security = $this->createConfiguredMock(Security::class, ['getUser' => new User('test@example.com', 'secret')]);

        $context = new UserContext(
            $security,
            $this->createMock(UserRepository::class)
        );

        $this->expectException(UserNotFound::class);

        $context->getUser();
    }
}
