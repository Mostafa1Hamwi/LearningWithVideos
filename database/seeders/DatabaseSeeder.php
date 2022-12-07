<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Choice;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Language;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create([
            'role_name' => 'root'
        ]);
        Role::create([
            'role_name' => 'admin'
        ]);
        Role::create([
            'role_name' => 'student'
        ]);

        Language::create([
            'language_name' => 'English',
            'language_photo' => 'english.png'
        ]);
        Language::create([
            'language_name' => 'Arabic',
            'language_photo' => 'arabic.png'
        ]);

        Unit::create([
            'unit_name' => 'Unit 1',
            'unit_overview' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
            'unit_level' => 'Beginner',
            'unit_status' => 'Done',
            'language_id' => '1'
        ]);

        Unit::create([
            'unit_name' => 'Unit 2',
            'unit_overview' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo conesquat. ',
            'unit_level' => 'Beginner',
            'unit_status' => 'Undone',
            'language_id' => '1'
        ]);


        $password = bcrypt(123456);

        User::create([
            'first_name' => 'Mostafa',
            'last_name' => 'Hamwi',
            'gender' => 'm',
            'birth_date' => '2001-08-05',
            'user_photo' => '/images/users/illustration-1.gif',
            'email' => 'Mostafa@test.com',
            'password' => $password,
            'role_id' => 1,
        ]);

        Question::create([
            'type' => 't',
            'question' => 'Are you watching TV?',
            'unit_id' => '2',
        ]);

        Choice::create([
            'choice' => 'Yes',
            'is_correct' => '1',
            'question_id' => '1'
        ]);

        Choice::create([
            'choice' => 'Good',
            'is_correct' => '0',
            'question_id' => '1'
        ]);

        Choice::create([
            'choice' => 'Bad',
            'is_correct' => '0',
            'question_id' => '1'
        ]);

        DB::table('unit_user')->insert([
            'unit_id' => '1',
            'user_id' => '1',
        ]);
    }
}
