<?php

namespace Tests\Feature;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\User;
use App\Entities\Visit;
use App\Entities\Visitor;
use App\Entities\Website;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TablePageViewsApiTest extends TestCase
{
    use RefreshDatabase;

    private const RESPONSE_STRUCTURE = [
        'data' => [
            '*' => [
                'page_url',
                'page_title',
                'count_page_views',
                'bounce_rate',
                'exit_rate'
            ]
        ],
        'meta' => []
    ];

    private const URL = 'api/v1/table-page-views';

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Website::class)->create();
        factory(Visitor::class, 3)->create();
        factory(Page::class, 3)->create();
        factory(GeoPosition::class)->create();
        factory(System::class)->create();
        factory(Session::class, 3)->create();
        factory(Visit::class, 5)->create();
    }

    public function testGetTablePageViewsItems()
    {
        $data = [
            'filter' => [
                'startDate' => (string) Carbon::create(2019)->timestamp,
                'endDate' => (string) Carbon::now()->timestamp
            ]
        ];

        $this->actingAs($this->user)
            ->json('GET', self::URL, $data)
            ->assertStatus(200)
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
    }
}