<?php

$factory->define(App\Models\Person::class, function (Faker\Generator $faker) {
    return [
        'name'          => $faker->name,
        'uuid'          => uuid(),
        'created_at'    => Carbon::now()
    ];
});
