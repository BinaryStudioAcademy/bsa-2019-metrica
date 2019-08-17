<?php

namespace Tests;

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
    const BROWSERS = [
        'Mozilla/5.0 (Windows NT 6.2; en-US; rv:1.9.0.20) Gecko/20120922 Firefox/35.0',
        'Mozilla/5.0 (X11; Linux x86_64; rv:7.0) Gecko/20120215 Firefox/37.0',
        'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 4.0; Trident/3.1)'
    ];
    const SCREEN_HEIGHT = [
        '1595',
        '1638'
    ];
    const SCREEN_WIDTH = [
        '789',
        '920'
    ];
    const OS = [
        'Macintosh; U; PPC Mac OS X 10_5_0',
        'X11; Linux x86_64'
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

    public static function createUser(): User
    {
        return factory(User::class)->create();
    }

    public static function createVisitsBetweenDates(User $user, String $from,String $to): void
    {
        $website = factory(Website::class)->create(['user_id' => $user->id]);
        factory(Page::class, 3)->create(['website_id' => $website->id]);
        factory(Visitor::class, 15)->create();

        foreach (self::BROWSERS as $browser) {
            foreach (self::SCREEN_HEIGHT as $screen_height) {
                foreach (self::SCREEN_WIDTH as $screen_width) {
                    foreach (self::OS as $o_system) {
                        $systems[] = factory(System::class)->create(
                            [
                                'browser' => $browser,
                                'resolution_height' => $screen_height,
                                'resolution_width' => $screen_width,
                                'os' => $o_system
                            ]
                        );
                    }
                }
            }
        }

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

        foreach (self::LANGUAGES as $language) {
            foreach ($systems as $system) {
                $session = factory(Session::class)->create(
                    [
                        'system_id' => $system->id,
                        'language' => $language
                    ]
                );
                foreach ($geo_positions as $geo_position) {
                    factory(Visit::class)->create(
                        [
                            'geo_position_id' => $geo_position->id,
                            'session_id' => $session->id,
                            'visit_time' => new \DateTime('@' . rand($from, $to))
                        ]
                    );
                }
            }
        }
    }
}