<?php

use Illuminate\Database\Seeder;

class ApadrinamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Apadrinamiento::class, 50)->create();
    }
}
