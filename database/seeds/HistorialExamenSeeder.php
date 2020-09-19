<?php

use Illuminate\Database\Seeder;

class HistorialExamenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HistorialExamen::class, 50)->create();
    }
}
