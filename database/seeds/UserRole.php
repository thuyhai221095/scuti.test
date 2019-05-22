<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_user_roles')->insert([
            [
                'project_id' => 1,
                'member_id' => 1,
                'role' => 'DEV',
            ],
            [
                'project_id' => 1,
                'member_id' => 2,
                'role' => 'DEV',
            ],
            [
                'project_id' => 1,
                'member_id' => 3,
                'role' => 'DEV',
            ],
            [
                'project_id' => 2,
                'member_id' => 3,
                'role' => 'DEV',
            ],
            [
                'project_id' => 2,
                'member_id' => 2,
                'role' => 'DEV',
            ],
        ]);
    }
}
