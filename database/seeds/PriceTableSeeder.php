<?php

use Illuminate\Database\Seeder;

class PriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PriceModel::class, 200)->create()->each(function($post){
            $post->save();
        });
    }
}
