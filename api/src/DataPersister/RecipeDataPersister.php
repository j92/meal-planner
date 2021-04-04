<?php
declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Core\Service\RecipeServiceInterface;
use App\Entity\Recipe;

final class RecipeDataPersister implements ContextAwareDataPersisterInterface
{
    private RecipeServiceInterface $recipeService;

    public function __construct(RecipeServiceInterface $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Recipe;
    }

    public function persist($data, array $context = [])
    {
        if ($data instanceof Recipe && $data->getId() === null) {
            return $this->recipeService->createRecipe($data);
        }
    }

    public function remove($data, array $context = [])
    {
        return $this->recipeService->createRecipe($data);
    }
}
