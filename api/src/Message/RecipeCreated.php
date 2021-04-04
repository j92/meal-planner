<?php
declare(strict_types=1);

namespace App\Message;

final class RecipeCreated
{
    private int $recipeId;

    public function __construct(int $recipeId)
    {
        $this->recipeId = $recipeId;
    }

    public function getRecipeId(): int
    {
        return $this->recipeId;
    }
}
