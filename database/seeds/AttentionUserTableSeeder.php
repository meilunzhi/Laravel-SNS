<?php

use Illuminate\Database\Seeder;

class AttentionUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\AttentionUser::class,1)->create();
    }
}
