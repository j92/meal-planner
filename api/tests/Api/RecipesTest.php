<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\RecipeRepository;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class RecipesTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateRecipe(): void
    {
        $response = static::createClient()->request('POST', '/recipes', ['json' => [
            'name' => 'Pizza Hawaii',
            'sourceUrl' => 'https://pizza.hawaii'
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Recipe',
            '@type' => 'Recipe',
            'name' => 'Pizza Hawaii',
            'sourceUrl' => 'https://pizza.hawaii'
        ]);

        $this::assertMatchesRegularExpression('~^/recipes/\d+$~', $response->toArray()['@id']);

        $id = $response->toArray()['id'];

        /** @var RecipeRepository $recipes */
        $recipes = self::$container->get(RecipeRepository::class);
        $recipe = $recipes->find($id);

        self::assertNotNull($recipe->getOwner());
    }
}
