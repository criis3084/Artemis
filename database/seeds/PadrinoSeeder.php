<?php

use Illuminate\Database\Seeder;

class PadrinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Padrino::class, 50)->create();
    }
}
