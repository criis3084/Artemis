<?php

use Illuminate\Database\Seeder;

class DestinoInversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DestinoInversion::class, 50)->create();
    }
}
