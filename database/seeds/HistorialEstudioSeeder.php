<?php

use Illuminate\Database\Seeder;

class HistorialEstudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HistorialEstudio::class, 50)->create();
    }
}
