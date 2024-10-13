<?php

use Illuminate\Database\Seeder;

class ConceptosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lista = ['concepto 1',
                  'concepto 2',
                  'concepto 3',
                  'concepto 4',
                  'concepto 5'];

        foreach ($lista as $obj){
            DB::table('conceptos')->insert([
                'nombre'     => $obj,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
