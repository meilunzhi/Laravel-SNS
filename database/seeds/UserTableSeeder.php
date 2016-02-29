<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Model\User', 500)->create()->each(function($u) {
            $u->articles()->save(factory('App\Model\Article')->make());
        });
    }
}
