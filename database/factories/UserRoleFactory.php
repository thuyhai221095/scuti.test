<?php

use Faker\Generator as Faker;
use App\Models\TblUserRole;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'project_id' => 1,
        'member_id' => 1,
        'role' => 'DEV'
    ];
});
