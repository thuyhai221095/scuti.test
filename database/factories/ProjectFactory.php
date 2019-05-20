<?php

use Faker\Generator as Faker;

use App\Models\TblProject;

$factory->define(TblProject::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'infomation' => str_random(20),
        'type' =>  'lab',
        'status' => 'done',
        'deadline' => date('Y-m-d')
    ];
});
