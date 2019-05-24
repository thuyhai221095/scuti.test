<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_statuses')->insert([
            [
                'name' => 'Planned',
                'value' => 'planned',
            ],
            [
                'name' => 'Onhold',
                'value' => 'onhold',
            ],
            [
                'name' => 'Doing',
                'value' => 'doing',
            ],
            [
                'name' => 'Done',
                'value' => 'done',
            ],
            [
                'name' => 'Cancelled',
                'value' => 'cancelled',
            ]
        ]);
    }
}
