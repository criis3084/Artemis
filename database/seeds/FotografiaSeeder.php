<?php

use Illuminate\Database\Seeder;

class FotografiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Fotografia::class, 50)->create();
    }
}
