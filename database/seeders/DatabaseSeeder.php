<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

//        DB::table('users')->insert([
//            'name' => 'Admin',
//            'email' => 'Slayvi555@gmail.com',
//            'password' => bcrypt('Admin12345*'),
//        ]);
//
//        DB::table('roles')->insert([
//            'name' => 'admin'
//        ]);
//
//        DB::table('roles')->insert([
//            'name' => 'manager'
//        ]);
//
//        DB::table('role_user')->insert([
//            'role_id' => 1,
//            'user_id' => 1
//        ]);

    }
}
