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
        $this->call(RolSeeder::class);
        $this->call(AldeaSeeder::class);
        $this->call(EscuelaSeeder::class);
        $this->call(PpiSeeder::class);
        $this->call(FotografiaSeeder::class);
        $this->call(GrupoPrestamoSeeder::class);
        $this->call(DestinoInversionSeeder::class);
        $this->call(TipoViviendaSeeder::class);
        $this->call(TipoExamenSeeder::class);
        $this->call(TipoCitaSeeder::class);
        $this->call(TipoPacienteSeeder::class);
        $this->call(ProfesionSeeder::class);
        $this->call(CasaMedicaSeeder::class);
        $this->call(CategoriaMedicamentoSeeder::class);
        $this->call(SectorSeeder::class);
        $this->call(PersonaSinAccesoSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(NinoSeeder::class);
        $this->call(EncargadoSeeder::class);
        $this->call(PadrinoSeeder::class);
        $this->call(ConstructorSeeder::class);
        $this->call(MicroprestamoSeeder::class);
        $this->call(MedicamentoSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(PacienteSeeder::class);
        $this->call(TutorSeeder::class);
        $this->call(AdministrativoSeeder::class);
        $this->call(ClinicoSeeder::class);
        $this->call(ApadrinamientoSeeder::class);
        $this->call(RelacionSeeder::class);
        $this->call(ViviendaSeeder::class);
        $this->call(HistorialPpiSeeder::class);
        $this->call(HistorialFotografiaSeeder::class);
        $this->call(DetalleIntegranteSeeder::class);
        $this->call(ExamenSeeder::class);
        $this->call(BeneficioSeeder::class);
        $this->call(LoteSeeder::class);
        $this->call(IngresoMedicamentoSeeder::class);
        $this->call(SalidaMedicamentoSeeder::class);
        $this->call(TutoriaSeeder::class);
        $this->call(CorrespondenciaSeeder::class);
        $this->call(AbonoPrestamoSeeder::class);
        $this->call(AbonoViviendaSeeder::class);
        $this->call(CitaSeeder::class);
        $this->call(DetalleBeneficioSeeder::class);
        $this->call(DetalleIngresoSeeder::class);
        $this->call(DetalleSalidaSeeder::class);
        $this->call(HistorialClinicoSeeder::class);
        $this->call(HistorialExamenSeeder::class);
        $this->call(RecetaSeeder::class);
        $this->call(AsignacionMedicamentoSeeder::class);
        $this->call(EstudioSocioeconomicoSeeder::class);
        $this->call(HistorialEstudioSeeder::class);
        $this->call(HistorialAbonoViviendaSeeder::class);
        $this->call(HistorialCorrespondenciaSeeder::class);
        
    }
}
