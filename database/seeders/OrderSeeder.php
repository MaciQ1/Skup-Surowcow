<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::withoutForeignKeyConstraints(function () {
            Order::truncate();
        });

        Order::insert(
            [
                [
                    'user_id' => '2',
                    'material_id' => '8',
                    'quantity' => '2',
                    'final_price' => '2200',
                ],

                [
                    'user_id' => '2',
                    'material_id' => '1',
                    'quantity' => '15.5',
                    'final_price' => '310',
                ],

                [
                    'user_id' => '3',
                    'material_id' => '4',
                    'quantity' => '3',
                    'final_price' => '16500',
                ],

            ]
        );
    }
}
