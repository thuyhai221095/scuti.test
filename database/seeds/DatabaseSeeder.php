<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // MemberSeed::class,
            // ProjectSeed::class,
            // UserRole::class,
            // PositionSeeder::class,
            // StatusSeeder::class,
            // TypeSeeder::class,
            // RoleSeeder::class
        ]);
    }
}
