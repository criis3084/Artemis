<?php

use Illuminate\Database\Seeder;

class AldeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Aldea::class, 10)->create();
    }
}
