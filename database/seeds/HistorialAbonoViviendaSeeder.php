<?php

use Illuminate\Database\Seeder;

class HistorialAbonoViviendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HistorialAbonoVivienda::class, 50)->create();
    }
}
