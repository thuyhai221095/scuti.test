<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_roles')->insert([
            [
                'name' => 'DEV',
                'value' => 'DEV',
            ],
            [
                'name' => 'PL',
                'value' => 'PL',
            ],
            [
                'name' => 'PM',
                'value' => 'PM',
            ],
            [
                'name' => 'PO',
                'value' => 'PO',
            ],
            [
                'name' => 'SM',
                'value' => 'SM',
            ]
        ]);
    }
}
