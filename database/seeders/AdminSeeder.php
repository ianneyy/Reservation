<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ian Belarmino',
            'email' => 'iangomez464@gmail.com',
            'password' => Hash::make('pasword30'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
