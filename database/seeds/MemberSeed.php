<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_members')->insert([
            [
                'name' => 'Thuy',
                'infomation' => 'Infomation Thuy',
                'phone' => '0984287637',
                'date_of_birth' => '1995-10-22',
                'position' => 'junior',
            ],
            [
                'name' => 'Anh',
                'infomation' => 'Infomation Anh',
                'phone' => '06725450211',
                'date_of_birth' => '1990-11-16',
                'position' => 'junior',
            ],
            [
                'name' => 'Nhan',
                'infomation' => 'Infomation Nhan',
                'phone' => '0984285634',
                'date_of_birth' => '1994-10-04',
                'position' => 'junior',
            ],
            [
                'name' => 'Phuong',
                'infomation' => 'Infomation Phuong',
                'phone' => '0984281235',
                'date_of_birth' => '1996-03-04',
                'position' => 'bo',
            ]
        ]);
    }
}
