<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin1',
                'email' => 'afifnuruddinmaisaroh@gmail.com',
                'password' => Hash::make('1234'),
            ],
            [
                'name' => 'admin2',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('1234'),
            ]
        ]);
    }
}
