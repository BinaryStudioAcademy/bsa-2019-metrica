<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestDataFactory;
use Carbon\Carbon;

class TableErrorTest extends TestCase
{
    use RefreshDatabase;

    const DATE_FROM = '2019-08-20 00:00:00';
    const DATE_TO = '2019-08-24 23:59:59';
    const ENDPOINT = 'api/v1/errors/table-items';
    const PARAMETERS = [
        'page',
    ];
    const RESPONSE_STRUCTURE = [
        'data' => [
            '*' => [
                'parameter',
                'parameter_value',
                'count',
                'message',
                'stack_trace'
            ]
        ],
        'meta' => []
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
        TestDataFactory::createErrorsBetweenDates($this->user, self::DATE_FROM, self::DATE_TO);
    }
    public function testGetErrorsByParameterAction()
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
                ->assertJsonStructure(self::RESPONSE_STRUCTURE)
                ->assertJsonCount($this->getAssertedCount($parameter), 'data')
                ->json();

            $this->assertNotEmpty($result);
        }
    }

    public function testFailedGetErrorsByParameterAction()
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
}
