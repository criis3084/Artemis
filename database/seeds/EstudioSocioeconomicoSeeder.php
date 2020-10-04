<?php

use Illuminate\Database\Seeder;

class EstudioSocioeconomicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EstudioSocioeconomico::class, 50)->create();
    }
}
