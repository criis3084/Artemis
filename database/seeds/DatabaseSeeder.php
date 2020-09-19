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
        $this->call(TipoExamenSeeder::class);
        $this->call(ProfesionSeeder::class);
        $this->call(ClinicoSeeder::class);
        $this->call(TipoPacienteSeeder::class);
        $this->call(ExamenSeeder::class);
        $this->call(PacienteSeeder::class);
        $this->call(TipoCitaSeeder::class);
        $this->call(CitaSeeder::class);
        $this->call(HistorialExamenSeeder::class);
        $this->call(BeneficioSeeder::class);
        $this->call(CasaMedicaSeeder::class);
        $this->call(CategoriaMedicamentoSeeder::class);
        $this->call(MedicamentoSeeder::class);
        $this->call(DetalleBeneficioSeeder::class);
        $this->call(HistorialClinicoSeeder::class);
        $this->call(RecetaSeeder::class);
        $this->call(AsignacionMedicamentoSeeder::class);
        $this->call(SalidaMedicamentoSeeder::class);
        $this->call(LoteSeeder::class);
        $this->call(DetalleSalidaSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(IngresoMedicamentoSeeder::class);
        $this->call(DetalleIngresoSeeder::class);
        
    }
}
