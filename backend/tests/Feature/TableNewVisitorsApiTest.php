<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestDataFactory;
use Illuminate\Support\Carbon;
use App\Entities\User;
use App\Entities\Visit;
use App\Entities\Website;
use App\Entities\Session;
use App\Entities\GeoPosition;
use App\Entities\System;
use App\Entities\Page;
use App\Entities\Visitor;

class TableNewVisitorsApiTest extends TestCase
{
    use RefreshDatabase;

    const DATE_FROM = '2019-08-20 00:00:00';
    const DATE_TO = '2019-08-24 23:59:59';
    const ENDPOINT = '/api/v1/visitors/new-visitors-table/';
    const PARAMETERS = [
        'city',
        'country',
        'language',
        'browser',
        'operating_system',
        'screen_resolution'
    ];

    private $user;
    private $fromTimeStamp;
    private $toTimeStamp;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUser();
        $this->seedDataBase();
        $this->fromTimeStamp = (new Carbon(self::DATE_FROM))->timestamp;
        $this->toTimeStamp = (new Carbon(self::DATE_TO))->timestamp;
    }

    public function test_get_new_visitors_by_param()
    {
        $requestData = [
            'startDate' => $this->fromTimeStamp,
            'endDate' => $this->toTimeStamp,
        ];

        $queryString = '?filter[startDate]='.$requestData['startDate'].
                         '&filter[endDate]='.$requestData['endDate'].
                         '&filter[parameter]=';

        $expected = [
            'data' => [
                [
                    'parameter' => 'city',
                    'parameter_value' => 'Berlin',
                    'total' => 1,
                    'percentage' => 25
                ],
                [
                    'parameter' => 'city',
                    'parameter_value' => 'Kiev',
                    'total' => 1,
                    'percentage' => 25
                ]
            ],
            'meta' => []
        ];

        $parameter = 'city';
        $queryString .= $parameter;

        $this->actingAs($this->user)
            ->getJson(self::ENDPOINT.$queryString)
            ->assertJson($expected);
    }

    private function setUser(): User
    {
        return $this->user = factory(User::class)->create();
    }

    private function seedDataBase(): void
    {
        factory(Website::class)->create();

        foreach ($this->fakeData()['visitors_created'] as $created_at) {
            factory(Visitor::class)->create([
                'created_at' => $created_at
            ]);
        }

        factory(Page::class)->create();

        foreach ($this->fakeData()['geo_positions'] as $geo_position) {
            $geo_positions[] = factory(GeoPosition::class)->create(
                [
                    'country' => $geo_position['country'],
                    'city' => $geo_position['city']
                ]
            );
        }

        foreach ($this->fakeData()['systems'] as $system) {
            $systems[] = factory(System::class)->create($system);
        }

        foreach ($this->fakeData()['languages'] as $language) {
            foreach ($systems as $system) {
                $sessions[] = factory(Session::class)->create([
                    'system_id' => $system->id,
                    'language' => $language
                ]);
            }
        }

        foreach ($geo_positions as $i => $geo_position) {
            $visitorId = $i == 1 ? Visitor::min('id') : Visitor::min('id')+1;
            foreach ($sessions as $session) {
                factory(Visit::class)->create(
                    [
                        'geo_position_id' => $geo_position->id,
                        'session_id' => $session->id,
                        'visitor_id' => $visitorId,
                    ]
                );
            }
        }
    }


    private function fakeData(): array
    {
        return [
            'visitors_created' => [
                '2019-08-21 00:00:00',
                '2019-08-22 00:00:00',
                '2019-08-25 00:00:00',
                '2019-08-26 00:00:00',
            ],
            'languages'=> [
                'en',
                'ru',
            ],
            'geo_positions' => [
                [
                    'country' => 'Ukraine',
                    'city' => 'Kiev'
                ],
                [
                    'country' => 'Germany',
                    'city' => 'Berlin'
                ],
            ],
            'systems' => [
                [
                    'browser' => 'Mozilla/5.0 (Windows NT 6.2; en-US; rv:1.9.0.20) Gecko/20120922 Firefox/35.0',
                    'resolution_height' => '640',
                    'resolution_width' => '784',
                    'os' => 'Windows NT 6.0'
                ],
                [
                    'browser' => 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0) Gecko/20120215 Firefox/37.0',
                    'resolution_height' => '576',
                    'resolution_width' => '1024',
                    'os' => 'Macintosh; U; PPC Mac OS X 10_5_0'
                ],
                [
                    'browser' => 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 5.2; Trident/3.1)',
                    'resolution_height' => '768',
                    'resolution_width' => '1152',
                    'os' => 'Windows NT 6.0'
                ],
                [
                    'browser' => 'Mozilla/5.0 (Windows NT 6.2; en-US; rv:1.9.0.20) Gecko/20120922 Firefox/35.0',
                    'resolution_height' => '576',
                    'resolution_width' => '1024',
                    'os' => 'Macintosh; U; PPC Mac OS X 10_5_0'
                ],
                [
                    'browser' => 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0) Gecko/20120215 Firefox/37.0',
                    'resolution_height' => '640',
                    'resolution_width' => '784',
                    'os' => 'X11; Linux i686'
                ],
                [
                    'browser' => 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 5.2; Trident/3.1)',
                    'resolution_height' => '576',
                    'resolution_width' => '1024',
                    'os' => 'X11; Linux i686'
                ]
            ],
        ];
    }
}
