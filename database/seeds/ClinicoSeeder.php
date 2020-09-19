<?php

use Illuminate\Database\Seeder;

class ClinicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Clinico::class, 50)->create();
    }
}
