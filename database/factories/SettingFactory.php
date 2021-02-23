<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Setting;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(App\Models\Setting::class, function (Faker $faker) {
    return [
        'setting_api_whatsapp' => Str::uuid(),
        'setting_api_telegram' => Str::uuid(),
        'setting_smtp_host' => $faker->domainName,
        'setting_smtp_port' => 465,
        'setting_smtp_user' => $faker->freeEmail,
        'setting_smtp_password' => $faker->password,
        'setting_logo' => 'default-logo.png',
        'setting_favicon' => 'default-favicon.ico',
    ];
});
