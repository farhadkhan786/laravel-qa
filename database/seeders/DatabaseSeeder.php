<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(3)->create()->each(function ($u) {
            $u->questions()->saveMany(
                  Question::factory()->count(rand(1, 5))->make()
              );
        });
    }
}
