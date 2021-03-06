<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestDataFactory;

class TableVisitorsApiTest extends TestCase
{
    use RefreshDatabase;

    const DATE_FROM = '1563148800';
    const DATE_TO = '1566049604';
    const ENDPOINT = 'api/v1/table-visitors/count-total';
    const PARAMETERS = [
        'city',
        'country',
        'language',
        'browser',
        'operating_system',
        'screen_resolution'
    ];

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = TestDataFactory::createUser();
        TestDataFactory::createVisitsBetweenDates($this->user, self::DATE_FROM, self::DATE_TO);
    }
    public function testGetVisitorsByParameterAction()
    {
        foreach (self::PARAMETERS as $parameter) {
            $query = [
                'filter' => [
                    'startDate' => self::DATE_FROM,
                    'endDate' => self::DATE_TO,
                    'parameter' => $parameter
                ]
            ];

            $result = $this->actingAs($this->user)
                ->json('GET', self::ENDPOINT, $query)
                ->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'parameter',
                            'parameter_value',
                            'total',
                            'percentage'
                        ]
                    ],
                    'meta' => []
                ])
                ->assertJsonCount($this->getAssertedCount($parameter), 'data')
                ->json();

            $this->assertNotEmpty($result);
        }
    }

    public function testFailedGetVisitorsByParameterAction()
    {
        $query = [
            'filter' => [
                'startDate' => self::DATE_FROM,
                'endDate' => self::DATE_TO,
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
