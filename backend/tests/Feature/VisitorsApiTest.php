<?php

namespace Tests\Feature;

use App\Entities\User;
use Tests\TestCase;

class VisitorsApiTest extends TestCase
{
    public function testNewVisitorsAction()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->call('GET', 'api/v1/visitors/new');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAllVisitorsAction()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->call('GET', 'api/v1/visitors');

        $this->assertEquals(200, $response->getStatusCode());
    }
}