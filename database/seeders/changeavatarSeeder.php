<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use PDO;

class changeavatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach($users as $user){
            $user->avatar = 'upload/avatars/avatar.png';
            $user->save();
        }
    }
}
