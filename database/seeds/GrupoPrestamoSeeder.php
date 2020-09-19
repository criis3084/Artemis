<?php

use Illuminate\Database\Seeder;

class GrupoPrestamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\GrupoPrestamo::class, 50)->create();
    }
}
