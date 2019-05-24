<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_positions')->insert([
            [
                'name' => 'Intern',
                'value' => 'intern',
            ],
            [
                'name' => 'Junior',
                'value' => 'junior',
            ],
            [
                'name' => 'Senior',
                'value' => 'senior',
            ],
            [
                'name' => 'PM',
                'value' => 'pm',
            ],
            [
                'name' => 'CEO',
                'value' => 'ceo',
            ],
            [
                'name' => 'CTO',
                'value' => 'cto',
            ],
            [
                'name' => 'BO',
                'value' => 'bo',
            ],
        ]);
    }
}
