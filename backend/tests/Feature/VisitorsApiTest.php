<?php

namespace tests\Feature;

use Tests\TestCase;

class VisitorsApiTest extends TestCase
{
    public function testNewVisitorsAction()
    {
        $response = $this->call('GET', 'api/v1/visitors/new');

        $this->assertEquals(200, $response->getStatusCode());
    }
}