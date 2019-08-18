<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;
use App\Entities\Website;
use App\Entities\Visitor;
use App\Entities\Session;
use App\Entities\Page;
use App\Entities\System;
use App\Entities\GeoPosition;
use App\Entities\Demographic;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use App\Repositories\EloquentSessionRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class CountSessionsTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUser();
        $this->seedDataBase();
    }

    public function test_count_sessions()
    {
        $dateFilter = [
            'startDate' => 1566086400, // 18.08.19 00:00:00
            'endDate' => 1566259200, // 20.08.19 00:00:00
        ];

        $queryString = '?filter[startDate]='.$dateFilter['startDate'].
                         '&filter[endDate]='.$dateFilter['endDate'];

        $expected = [
                    'data' => [
                        'quantity_sessions' => 4
                    ],
                    'meta' => []
               ];

        $this->actingAs($this->user)
            ->getJson('/api/v1/sessions/count/'.$queryString)
            ->assertJson($expected);
    }

    private function setUser(): User
    {
        return $this->user = factory(User::class)->create();
    }

    private function seedDataBase(): void
    {

        factory(Website::class)->create();
        factory(Visitor::class)->create();
        factory(Page::class)->create();
        factory(System::class)->create();
        factory(GeoPosition::class)->create();
        factory(Demographic::class)->create();
        $this->createSessions();
    }

    private function createSessions(): void
    {
        foreach ($this->sessionStarts() as $sessionStart) {
            factory(Session::class)->create([
               'start_session' => $sessionStart,
            ]);
        }
    }

    private function sessionStarts(): array
    {
        return [
            '2019-08-18 10:00:00',
            '2019-08-18 20:00:00',
            '2019-08-19 10:00:00',
            '2019-08-19 20:00:00',
            '2019-08-21 10:00:00',
        ];
    }
}


