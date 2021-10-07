<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Question;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->where('votable_type', Question::class)->delete();

        $users = User::all();
        $numberOfUSers = $users->count();
        $votes = [-1, 1];

        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(1, $numberOfUSers); $i++) {
                $user = $users[$i];
                $user->voteQuestions($question, $votes[rand(0, 1)]);
            }
        }
    }
}
