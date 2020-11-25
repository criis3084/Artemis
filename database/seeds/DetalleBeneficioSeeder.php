<?php

use Illuminate\Database\Seeder;

class DetalleBeneficioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DetalleBeneficio::class, 200)->create();
    }
}
