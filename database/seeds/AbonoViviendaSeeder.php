<?php

use Illuminate\Database\Seeder;

class AbonoViviendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AbonoVivienda::class, 20)->create();
    }
}
