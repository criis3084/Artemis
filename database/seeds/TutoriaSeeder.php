<?php

use Illuminate\Database\Seeder;

class TutoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Tutoria::class, 10)->create();
    }
}
