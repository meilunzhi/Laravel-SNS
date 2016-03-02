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

$factory->define(App\Model\User::class, function (Faker\Generator $faker) {
    return [
        'uid' => '123456',
        'login_type' => 1,
        'nickname' => $faker->name,
        'profile_img' => '2016-01-14/569766cb70cab.jpg',
        'phone' => '123',
        'password' => '202cb962ac59075b964b07152d234b70'
    ];
});

$factory->define(App\Model\Article::class, function (Faker\Generator $faker) {
    return [
        'user_id' => rand(53,75),
        'category_id' => rand(1,4),
        'title' => $faker->title,
        'content' => $faker->address,
        'view' => rand(1,1000),
        'praise' => rand(1,1000)
    ];
});

$factory->define(App\Model\Image::class, function (Faker\Generator $faker) {
    return [
        'article_id' => 62,
        'url' => 'http://www.hua.com/flower_picture/baihehua/images/l08b.jpg',
    ];
});

$factory->define(App\Model\Comment::class, function (Faker\Generator $faker) {
    return [
        'article_id' => 66,
        'user_id' => 61,
        'parent_comment_id' => 44,
        'content' => $faker->address
    ];
});

$factory->define(App\Model\AttentionCategory::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 63,
        'category_id' => 4
    ];
});

$factory->define(App\Model\AttentionUser::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 52,
        'attention_user_id' => 54
    ];
});
