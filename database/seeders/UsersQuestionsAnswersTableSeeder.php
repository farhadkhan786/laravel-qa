<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('answers')->delete();
        \DB::table('users')->delete();
        \DB::table('questions')->delete();
        User::factory()->count(3)->create()->each(function ($u) {
            $u->questions()->saveMany(
                Question::factory()->count(rand(1, 5))->make()
            )
                ->each(function ($q){
                    $q->answers()->saveMany(
                        Answer::factory()->count(rand(1, 5))->make());
                });
        });
    }
}
