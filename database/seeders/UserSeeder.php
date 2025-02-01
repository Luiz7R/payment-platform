<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(['email' => 'barryallen@starindustries.com'], [
            'firstName' => 'Bartholomew',
            'lastName' => 'Allen',
            'email' => 'barryallen@starindustries.com',
            'password' => Hash::make(Str::random(17)),
            'balance' => 5000,
            'user_type' => User::COMMON,
            'document' => '795.002.109-27'
        ]);

        User::firstOrCreate(['email' => 'oliverqueen@starindustries.com'], [
            'firstName' => 'Oliver',
            'lastName' => 'Queen',
            'email' => 'oliverqueen@starindustries.com',
            'password' => Hash::make(Str::random(17)),
            'balance' => 0,
            'user_type' => User::MERCHANT,
            'document' => '109.027.002-95'
        ]);
    }
}
