<?php

namespace Tests;

use App\Entities\Error;
use App\Entities\User;
use App\Entities\Visit;
use App\Entities\Website;
use App\Entities\Session;
use App\Entities\GeoPosition;
use App\Entities\System;
use App\Entities\Page;
use App\Entities\Visitor;

class TestDataFactory
{
    const LANGUAGES = [
        'en',
        'ru',
        'as'
    ];

    const GEO_POSITIONS = [
        'Ukraine' => [
            'Lviv',
            'Dnipro'
        ],
        'USA' => [
            'Boston',
            'Dallas',
            'Seattle'
        ]
    ];

    const PAGES = [
        '/home',
        '/contacts',
        '/about'
    ];

    public static function createUser(): User
    {
        return factory(User::class)->create();
    }

    public static function createVisitsBetweenDates(Website $website, String $from, String $to): void
    {
        factory(Page::class, 3)->create(['website_id' => $website->id]);
        factory(Visitor::class, 15)->create();

        foreach (self::GEO_POSITIONS as $country_name => $cities) {
            foreach ($cities as $city_name) {
                $geo_positions[] = factory(GeoPosition::class)->create(
                    [
                        'country' => $country_name,
                        'city' => $city_name
                    ]
                );
            }
        }
        foreach (self::systemsData() as $systemsDatum) {
            $systems[] = factory(System::class)->create(
                $systemsDatum
            );
        }


        foreach (self::LANGUAGES as $language) {
            foreach ($systems as $system) {
                $sessions[] = factory(Session::class)->create(
                    [
                        'system_id' => $system->id,
                        'language' => $language,
                        'start_session' => new \DateTime('@' . rand($from, $to))
                    ]
                );
            }
        }
        foreach ($geo_positions as $geo_position) {
            foreach ($sessions as $session) {
                factory(Visit::class)->create(
                    [
                        'geo_position_id' => $geo_position->id,
                        'session_id' => $session->id,
                        'visit_time' => new \DateTime('@' . rand($from, $to))
                    ]
                );
            }

            $bounce_visitor = factory(Visitor::class)->create([
                'created_at' => '2019-08-21 00:00:00'
            ]);
            $bounce_session = factory(Session::class)->create([
                'language' => 'en',
                'start_session' => '2019-08-21 00:00:00',
                'end_session' => '2019-08-21 00:01:00',
                'visitor_id' => $bounce_visitor->id
            ]);
            factory(Visit::class)->create([
                'geo_position_id' => $geo_position->id,
                'visit_time' => '2019-08-21 00:00:00',
                'visitor_id' => $bounce_visitor->id,
                'session_id' => $bounce_session->id
            ]);
        }
    }

    public static function systemsData(): array
    {
        return [
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
        ];
    }

    public static function createErrorsBetweenDates(Website $website, String $from, String $to): void
    {
        foreach (self::PAGES as $page_url) {
            factory(Page::class)->create(
                [
                    'website_id' => $website->id,
                    'url' => $page_url
                ]
            );
        }
        factory(Visitor::class, 15)->create();

        foreach (self::GEO_POSITIONS as $country_name => $cities) {
            foreach ($cities as $city_name) {
                $geo_positions[] = factory(GeoPosition::class)->create(
                    [
                        'country' => $country_name,
                        'city' => $city_name
                    ]
                );
            }
        }
        foreach (self::systemsData() as $systemsDatum) {
            $systems[] = factory(System::class)->create(
                $systemsDatum
            );
        }


        foreach ($systems as $system) {
            $sessions[] = factory(Session::class)->create(
                [
                    'system_id' => $system->id,
                    'start_session' => new \DateTime('@' . rand($from, $to))
                ]
            );
        }
        foreach ($geo_positions as $geo_position) {
            foreach ($sessions as $session) {
                factory(Visit::class)->create(
                    [
                        'geo_position_id' => $geo_position->id,
                        'session_id' => $session->id,
                        'visit_time' => new \DateTime('@' . rand($from, $to))
                    ]
                );
            }
        }
        for ($i = 0; $i < 5; $i++) {
            $visit = $website->visits->random();
            factory(Error::class, 5)->create([
                'visitor_id' => $visit->visitor->id,
                'page_id' => $visit->page->id
            ]);
        }
    }
}