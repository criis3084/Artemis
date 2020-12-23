<?php

use Illuminate\Database\Seeder;

class AbonoPrestamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AbonoPrestamo::class, 10)->create();
    }
}
