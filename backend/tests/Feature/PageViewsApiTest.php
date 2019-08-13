<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\User;
use Tests\TestCase;

final class PageViewsApiTest extends TestCase
{
    public function testPageViewsAction()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->call('GET', 'api/v1/pages/'
            . 1
            . '/views');
        $this->assertEquals(200, $response->getStatusCode());
    }
}