<?php

namespace Database\Seeders;
use App\models\user;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\support\facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'fname' => 'Rabby',
                'lname' => 'Khan',
                'phone' => '+8801920202157',
                'email' => 'rabbykhanswe@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        User::create(
            [
                'fname' => 'Junayet',
                'lname' => 'Methu',
                'phone' => '+8801827340454',
                'email' => 'junayetmethu@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        User::create(
            [
                'fname' => 'Rabby',
                'lname' => 'Khan',
                'phone' => '+8801611135313',
                'email' => 'rabbykhan@gmail.com',
                'password' => Hash::make('11223345'),
                'role' => 'customer',
                'is_verified' => true,
            ]          
        );
    }
}
