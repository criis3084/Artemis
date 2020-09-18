<?php

use Illuminate\Database\Seeder;

class CorrespondenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Correspondencia::class, 50)->create();
    }
}
