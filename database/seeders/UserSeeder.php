<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            User::truncate();
        });

        User::insert(
            [
                [
                    'login' => 'mq4321',
                    'email' => 'mq4321@email.com',
                    'password' => Hash::make('4321'),
                    'role' => 'admin',
                    'address' => 'Brzozów, ul. Drzewiasta 2/22',
                    'phone_number' => '132912920',
                ],

                [
                    'login' => 'filip_123',
                    'email' => 'filip_123@email.com',
                    'password' => Hash::make('123'),
                    'role' => 'user',
                    'address' => 'Bydgoszcz, ul.Krasna 72',
                    'phone_number' => '432532921',
                ],

                [
                    'login' => 'karo981',
                    'email' => 'karo981@email.com',
                    'password' => Hash::make('981'),
                    'role' => 'user',
                    'address' => 'Brzeziny, ul. Gąbczasta 13',
                    'phone_number' => '932431186',
                ],
            ]
        );
    }
}
