<?php

use App\Entities\Page;
use App\Entities\Session;
use App\Entities\User;
use App\Entities\Visit;
use App\Entities\Visitor;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class InitVisitorsSeeder extends Seeder
{
    private $user;

    public function run()
    {
        $this->user = User::query()->where('email', '=', 'info@metrica.fun')->first();
        $faker = Faker::create();
        $start = Carbon::yesterday()->subMonth();
        $now = Carbon::now();
        do {
            $visitorsCount = $faker->numberBetween(25, 60);
            for ($i=0; $i<$visitorsCount; $i++) {
                $visitsCount = $faker->numberBetween(1, 3);
                $this->createVisitorWithVisits($start, $visitsCount);
            }
            $start = $start->addDay();
        } while ($start < $now);
    }

    private function createVisitorWithVisits(DateTime $createdDate, int $countVisits)
    {
        $faker = Faker::create();
        $visitor = factory(Visitor::class)->create([
            'created_at' => $createdDate,
            'last_activity' => $createdDate,
            'website_id' => $this->user->website->id,
        ]);

        $userWebsite = $this->user->websites->filter(function($website){
          return $website->pivot->role === 'owner';
        })->first();

        $session = factory(Session::class)->create([
            'start_session' => $visitor->created_at,
            'entrance_page_id' => Page::inRandomOrder()->where('website_id', '=', $userWebsite->id)->first()->id,
            'visitor_id' => $visitor->id,
            'end_session' => Carbon::instance($visitor->created_at)->addMinutes($faker->numberBetween(15, 35)),
        ]);
        $delta = floor(($session->end_session->timestamp - $session->start_session->timestamp) / $countVisits);
        for ($i = 0; $i < $countVisits; $i++) {
            factory(Visit::class)->create([
                'session_id' => $session->id,
                'visitor_id' => $visitor->id,
                'visit_time' => $session->start_session->addMinutes($delta*$i),
                'page_id' => Page::inRandomOrder()->where('website_id', '=', $userWebsite->id)->first()->id,
            ]);
        }

        return $visitor;
    }
}
