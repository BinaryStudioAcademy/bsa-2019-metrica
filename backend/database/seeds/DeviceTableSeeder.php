<?php

use App\Entities\Device;
use Illuminate\Database\Seeder;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Device::class, 20)->create();
    }
}
