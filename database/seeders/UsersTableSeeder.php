<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Customer
        DB::table('users')->insert([
            'name'=>'Customer',
            'email'=>'customer@gmail.com',
            'password'=>Hash::make('12345678'),
        ]);

        //Admin
        DB::table('admins')->insert([
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('1111'),
        ]);
    }
}
