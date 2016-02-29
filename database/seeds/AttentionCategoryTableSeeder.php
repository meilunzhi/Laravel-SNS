<?php

use Illuminate\Database\Seeder;

class AttentionCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\AttentionCategory::class,1)->create();
    }
}
