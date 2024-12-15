<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::withoutForeignKeyConstraints(function () {
            Warehouse::truncate();
        });


        Warehouse::insert(
            [
                [
                    'material_id' => '1',
                    'in_stock' => '300',
                ],

                [
                    'material_id' => '2',
                    'in_stock' => '200',
                ],

                [
                    'material_id' => '3',                   //skaliste się tu kończą (id [1,2,3])
                    'in_stock' => '30',                    //piasek, żwir, marmur
                ],

                [
                    'material_id' => '4',
                    'in_stock' => '20',
                ],

                [
                    'material_id' => '5',
                    'in_stock' => '80',
                ],

                [
                    'material_id' => '6',
                    'in_stock' => '15',
                ],

                [
                    'material_id' => '7',               //metaliczne się tu kończą (id [1,2,3,3])
                    'in_stock' => '10',                //stal, żelazo, aluminium, miedź
                ],

                [
                    'material_id' => '8',
                    'in_stock' => '130',
                ],

                [
                    'material_id' => '9',
                    'in_stock' => '40',
                ],

                [
                    'material_id' => '10',                          //chemiczne się tu kończą (id [1,2,3])
                    'in_stock' => '25',                            //węgiel, sól kamienna, siarka
                ],

            ]
        );
    }
}
