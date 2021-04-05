<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class PlansTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreatePlan(): void
    {
        $response = static::createClient()->request('POST', '/plans', ['json' => [
            'name' => 'Plan for 5 April - 10 April',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Plan',
            '@type' => 'Plan',
            'name' => 'Plan for 5 April - 10 April',
        ]);

        $this::assertMatchesRegularExpression('~^/plans/\d+$~', $response->toArray()['@id']);
    }
}
