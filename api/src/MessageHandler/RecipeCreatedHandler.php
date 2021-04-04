<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Core\Service\RecipeServiceInterface;
use App\Message\RecipeCreated;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RecipeCreatedHandler implements MessageHandlerInterface
{
    private RecipeServiceInterface $recipeService;

    public function __construct(RecipeServiceInterface $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function __invoke(RecipeCreated $message): void
    {
        $this->recipeService->downloadRecipeFromSourceUrl($message->getRecipeId());
    }
}
