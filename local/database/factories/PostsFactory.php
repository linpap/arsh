<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
       return [
            'title' => str_random(10),
            'content' => str_random(1000),
            'featured_text' => str_random(250),
            'featured' => 'false',
            'status' => 'approved',
            'user_id' => function () {
            	return factory(App\User::class)->create()->id;
        	},
        	'category_id' => functioN(){
        		return factory(App\Category::class)->create()->id;
        	}
        ];
});
