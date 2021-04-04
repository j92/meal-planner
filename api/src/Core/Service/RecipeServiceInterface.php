<?php
declare(strict_types=1);

namespace App\Core\Service;

use App\Entity\Recipe;

interface RecipeServiceInterface
{
    public function getRecipeById(int $recipeId): Recipe;

    public function createRecipe(Recipe $recipe): Recipe;

    public function removeRecipe(Recipe $recipe): void;

    public function downloadRecipeFromSourceUrl(int $recipeId): void;
}
