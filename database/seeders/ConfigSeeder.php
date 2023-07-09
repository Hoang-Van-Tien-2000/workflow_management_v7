<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Config;
class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::truncate();

        $config = Config::create([
            'work_date_in_month'    => 22,
            'in_hour'               => "09:00:00",
            'out_hour'              => "18:00:00",
        ]);
    }
}
