<?php

use Faker\Generator as Faker;
use App\Models\TblMember;

$factory->define(TblMember::class, function (Faker $faker) {
    return [
        'name' => str_random(10),
        'infomation' => str_random(10),
        'phone' =>  mt_rand(100000, 999999),
        'date_of_birth' => date('Y-m-d'),
        'position' => 'junior',
    ];
});
