<?php

use Illuminate\Database\Seeder;

class NinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Nino::class, 50)->create();
    }
}
