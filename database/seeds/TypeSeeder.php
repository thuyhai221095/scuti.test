<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_types')->insert([
            [
                'name' => 'Lab',
                'value' => 'lab',
            ],
            [
                'name' => 'Single',
                'value' => 'single',
            ],
            [
                'name' => 'Acceptance',
                'value' => 'acceptance',
            ]   
        ]);
    }
}
