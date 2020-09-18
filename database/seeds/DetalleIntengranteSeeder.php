<?php

use Illuminate\Database\Seeder;

class DetalleIntengranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DetallleIntegrante::class, 50)->create();
    }
}
