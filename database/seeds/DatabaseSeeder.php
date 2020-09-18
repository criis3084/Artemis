<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EscuelaSeeder::class);
        $this->call(AldeaSeeder::class);
        $this->call(SectorSeeder::class);
        $this->call(PersonaSinAccesoSeeder::class);
        $this->call(NinoSeeder::class);
        $this->call(EncargadoSeeder::class);
        $this->call(RelacionSeeder::class);
        $this->call(PadrinoSeeder::class);
        $this->call(ApadrinamientoSeeder::class);
    }
}
