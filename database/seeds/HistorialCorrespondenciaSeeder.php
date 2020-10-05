<?php

use Illuminate\Database\Seeder;

class HistorialCorrespondenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HistorialCorrespondencia::class, 50)->create();
    }
}
