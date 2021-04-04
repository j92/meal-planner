<?php
declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Context\UserContextInterface;
use App\Entity\Recipe;

final class RecipeDataPersister implements ContextAwareDataPersisterInterface
{
//    private ContextAwareDataPersisterInterface $decoratedPersister;
//    private UserContextInterface $userContext;
//
//    public function __construct(
//        ContextAwareDataPersisterInterface $decoratedPersister,
//        UserContextInterface $userContext
//    ) {
//        $this->decoratedPersister = $decoratedPersister;
//        $this->userContext = $userContext;
//    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Recipe;
    }

    public function persist($data, array $context = [])
    {
        if ($data instanceof Recipe) {
            $user = $this->userContext->getUser();

            $data->setOwner($user);
        }

        return $this->decoratedPersister->persist($data);
    }

    public function remove($data, array $context = [])
    {
        return $this->decoratedPersister->remove($data);
    }
}
