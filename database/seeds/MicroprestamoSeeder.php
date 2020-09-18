<?php

use Illuminate\Database\Seeder;

class MicroprestamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Microprestamo::class, 50)->create();
    }
}
