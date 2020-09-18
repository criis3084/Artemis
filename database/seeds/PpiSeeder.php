<?php

use Illuminate\Database\Seeder;

class PpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Ppi::class, 50)->create();
    }
}
