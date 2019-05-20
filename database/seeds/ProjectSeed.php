<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_projects')->insert([
            [
                'name' => 'AE',
                'infomation' => 'AE project infomation',
                'type' => 'lab',
                'status' => 'planned',
                'deadline' => '2019-06-01',
            ],
            [
                'name' => 'ROC',
                'infomation' => 'ROC project infomation',
                'type' => 'lab',
                'status' => 'planned',
                'deadline' => '2019-06-05',
            ],
            [
                'name' => 'VIC',
                'infomation' => 'VIC project infomation',
                'type' => 'lab',
                'status' => 'planned',
                'deadline' => '2019-06-05',
            ],
            [
                'name' => 'AM',
                'infomation' => 'AM project infomation',
                'type' => 'lab',
                'status' => 'planned',
                'deadline' => '2019-06-01',
            ]
        ]);
    }
}
