<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'user_id' => 'a5c860decf204ea686aedbb6dbeb6ab1',
        'user_name' => 'Didi',
        'user_email' => 'abdillah1965didiokey@gmail.com',
        'user_phone' => '087727598653',
        'user_role' => 'admin',
        'user_daily_target' => 0,
        'user_password' => Hash::make('12345678'), // 12345678
        'user_image' => 'default.jpg',
    ];
    // return [
    //     'user_id' => str_replace('-', '', Str::uuid()),
    //     'user_name' => $faker->name,
    //     'user_email' => $faker->unique()->safeEmail,
    //     'user_phone' => $faker->unique()->e164PhoneNumber,
    //     'user_password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    //     'user_image' => 'default.jpg',
    // ];

});
