<?php

use Illuminate\Database\Seeder;

class TipoViviendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TipoVivienda::class, 10)->create();
    }
}
