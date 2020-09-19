<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $this->call(PpiSeeder::class);
        $this->call(HistorialPpiSeeder::class);
        $this->call(CorrespondenciaSeeder::class);
        $this->call(FotografiaSeeder::class);
        $this->call(HistorialFotografiaSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(AbonoViviendaSeeder::class);
        $this->call(TipoViviendaSeeder::class);
        $this->call(ViviendaSeeder::class);
        $this->call(ConstructorSeeder::class);
        $this->call(GrupoPrestamoSeeder::class);
        $this->call(DestinoInversionSeeder::class);
        $this->call(MicroprestamoSeeder::class);
        $this->call(DetalleIntegranteSeeder::class);
        $this->call(AbonoPrestamoSeeder::class);
        $this->call(TutorSeeder::class);
        $this->call(TutoriaSeeder::class);
    }
}
