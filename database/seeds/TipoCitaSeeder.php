<?php

use Illuminate\Database\Seeder;

class TipoCitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TipoCita::class, 10)->create();
    }
}
