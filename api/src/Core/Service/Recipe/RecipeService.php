<?php
declare(strict_types=1);

namespace App\Core\Service\Recipe;

use App\Context\User\UserContextInterface;
use App\Core\Recipe\RecipeDownloaderInterface;
use App\Core\Service\RecipeServiceInterface;
use App\Entity\Recipe;
use App\Message\RecipeCreated;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class RecipeService implements RecipeServiceInterface
{
    private EntityManagerInterface $entityManager;

    private RecipeRepository $recipes;

    private MessageBusInterface $messageBus;

    private UserContextInterface $userContext;

    private RecipeDownloaderInterface $downloader;

    public function __construct(
        EntityManagerInterface $entityManager,
        RecipeRepository $recipes,
        MessageBusInterface $messageBus,
        UserContextInterface $userContext,
        RecipeDownloaderInterface $downloader
    ) {
        $this->entityManager = $entityManager;
        $this->recipes = $recipes;
        $this->messageBus = $messageBus;
        $this->userContext = $userContext;
        $this->downloader = $downloader;
    }

    public function getRecipeById(int $recipeId): Recipe
    {
        $recipe = $this->recipes->find($recipeId);

        if ($recipe === null) {
            throw new \Exception();
        }

        return $recipe;
    }

    public function createRecipe(Recipe $recipe): Recipe
    {
        $recipe->setOwner($this->userContext->getUser());

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        $this->messageBus->dispatch(new RecipeCreated($recipe->getId()));

        return $recipe;
    }

    public function removeRecipe(Recipe $recipe): void
    {
        $this->entityManager->remove($recipe);
    }

    public function downloadRecipeFromSourceUrl(int $recipeId): void
    {
        $recipe = $this->getRecipeById($recipeId);

        $this->downloader->download($recipe);
    }
}
