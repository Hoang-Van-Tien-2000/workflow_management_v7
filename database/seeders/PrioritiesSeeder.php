<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = new Priority();
        $priorities->name = "red";
        $priorities->code = "#eb5a46";
        $priorities->status = 1;
        $priorities->save(); 

        $priorities1 = new Priority();
        $priorities1->name = "yellow";
        $priorities1->code = "#f2d600";
        $priorities1->status = 1;
        $priorities1->save();

        $priorities2 = new Priority();
        $priorities2->name = "orange";
        $priorities2->code = "#ff9f1a";
        $priorities2->status = 1;
        $priorities2->save();

        $priorities3 = new Priority();
        $priorities3->name = "blue";
        $priorities3->code = "#0079bf";
        $priorities3->status = 1;
        $priorities3->save();

        $priorities4 = new Priority();
        $priorities4->name = "pink";
        $priorities4->code = "#ff78cb";
        $priorities4->status = 1;
        $priorities4->save();
    }
}
