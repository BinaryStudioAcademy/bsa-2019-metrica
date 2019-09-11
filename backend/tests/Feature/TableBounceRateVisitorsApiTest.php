<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestDataFactory;
use Carbon\Carbon;

class TableBounceRateVisitorsApiTest extends TestCase
{
    use RefreshDatabase;

    const GEOLOCATION_RESPONSE_STRUCTURE = [
        'data' => [
            '*' => [
                'parameter',
                'parameter_value',
                'total',
                'percentage',
            ]
        ],
        'meta' => []
    ];

    private const DATE_FROM = '2019-08-20 00:00:00';
    private const DATE_TO = '2019-08-24 23:59:59';
    const ENDPOINT = 'api/v1/table-visitors/bounce-rate';
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

        $this->user = TestDataFactory::createUser();
        $this->fromTimeStamp = (new Carbon(self::DATE_FROM))->timestamp;
        $this->toTimeStamp = (new Carbon(self::DATE_TO))->timestamp;
        TestDataFactory::createVisitsBetweenDates($this->user, $this->fromTimeStamp, $this->toTimeStamp);
    }
    public function testGetVisitorsByParameterAction()
    {
        foreach (self::PARAMETERS as $parameter) {
            $query = [
                'filter' => [
                    'startDate' => (string) $this->fromTimeStamp,
                    'endDate' => (string) $this->toTimeStamp,
                    'parameter' => $parameter
                ]
            ];

            $result = $this->actingAs($this->user)
                ->json('GET', self::ENDPOINT, $query)
                ->assertStatus(200)
                ->assertJsonStructure(self::GEOLOCATION_RESPONSE_STRUCTURE)
                ->assertJsonCount($this->getAssertedCount($parameter), 'data')
                ->json();

            $this->assertNotEmpty($result);
        }
    }

    public function testFailedGetVisitorsByParameterAction()
    {
        $query = [
            'filter' => [
                'startDate' => (string) $this->fromTimeStamp,
                'endDate' => (string) $this->toTimeStamp,
                'parameter' => 'wrong_parameter'
            ],
        ];

        $result = $this->actingAs($this->user)
            ->json('GET', self::ENDPOINT, $query)
            ->assertStatus(400)
            ->assertJsonStructure([
                'error' => [
                    'message'
                ]
            ])
            ->json();
        $this->assertEquals('The filter.parameter must be one of available parameters.', $result['error']['message']);
    }

    public function getAssertedCount(String $parameter): int
    {
        switch ($parameter) {
            case 'city':
                return 5;
                break;
            case 'country':
                return 2;
                break;
            case 'language':
                return 3;
                break;
            case 'browser':
                return 3;
                break;
            case 'operating_system':
                return 3;
                break;
            case 'screen_resolution':
                return 3;
                break;
        }
    }
}
