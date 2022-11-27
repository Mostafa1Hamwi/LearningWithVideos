<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Language;
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
            'language_name' => 'English'
        ]);
        Language::create([
            'language_name' => 'Arabic'
        ]);

        Unit::create([
            'unit_name' => 'Unit 1',
            'unit_level' => 'Beginner',
            'unit_status' => 'Done',
            'language_id' => '1'
        ]);

        Unit::create([
            'unit_name' => 'Unit 2',
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
            'user_photo' => 'photo.png',
            'email' => 'Mostafa@test.com',
            'password' => $password,
            'role_id' => 1,
        ]);

        DB::table('unit_user')->insert([
            'unit_id' => '1',
            'user_id' => '1',
        ]);
    }
}
