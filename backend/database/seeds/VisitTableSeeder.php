<?php

use App\Entities\Visit;
use Illuminate\Database\Seeder;

class VisitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Visit::class, 50)->create();
    }
}
