<?php

use Illuminate\Database\Seeder;

class HistorialFotografiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HistorialFotografia::class, 50)->create();
    }
}
