<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::withoutForeignKeyConstraints(function () {
            Material::truncate();
        });

        Material::insert(
            [

                [
                    'type' => 'skaliste',
                    'name' => 'piasek',
                    'price_for_ton' => '20',
                    'img' => 'piasek.jpg',
                ],

                [
                    'type' => 'skaliste',
                    'name' => 'żwir',
                    'price_for_ton' => '40',
                    'img' => 'zwir.jpg',
                ],

                [
                    'type' => 'skaliste',               //skaliste się tu kończą (id [1,2,3])
                    'name' => 'marmur',
                    'price_for_ton' => '2000',
                    'img' => 'marmur.jpg',
                ],

                [
                    'type' => 'metaliczne',
                    'name' => 'stal',
                    'price_for_ton' => '5500',
                    'img' => 'stal.jpg',
                ],

                [
                    'type' => 'metaliczne',
                    'name' => 'żelazo',
                    'price_for_ton' => '600',
                    'img' => 'zelazo.jpg',
                ],

                [
                    'type' => 'metaliczne',
                    'name' => 'aluminium',
                    'price_for_ton' => '10000',
                    'img' => 'aluminium.jpg',
                ],

                [
                    'type' => 'metaliczne',                //metaliczne się tu kończą (id [1,2,3,4])
                    'name' => 'miedź',
                    'price_for_ton' => '40600',
                    'img' => 'miedz.jpg',
                ],

                [
                    'type' => 'chemiczne',
                    'name' => 'węgiel',
                    'price_for_ton' => '1100',
                    'img' => 'wegiel.jpg',
                ],

                [
                    'type' => 'chemiczne',
                    'name' => 'sól kamienna',
                    'price_for_ton' => '2200',
                    'img' => 'sol_kamienna.jpg',
                ],

                [
                    'type' => 'chemiczne',               //chemiczne się tu kończą (id [1,2,3])
                    'name' => 'siarka',
                    'price_for_ton' => '2600',
                    'img' => 'siarka.jpg',
                ],

            ]
        );
    }
}
