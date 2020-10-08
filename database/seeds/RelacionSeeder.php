<?php

use Illuminate\Database\Seeder;

class RelacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Relacion::class, 1000)->create();
    }
}
