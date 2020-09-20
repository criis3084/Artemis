<?php

use Illuminate\Database\Seeder;

class AsignacionMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AsignacionMedicamento::class, 50)->create();
    }
}
