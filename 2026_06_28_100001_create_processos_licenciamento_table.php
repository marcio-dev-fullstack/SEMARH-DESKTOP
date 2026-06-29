<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('processos_licenciamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cidadao_id')->constrained('users')->onDelete('cascade');
            $table->string('tipo_licenca'); // Ex: 'LP', 'LI', 'LO'
            $table->string('status')->default('Protocolado');
            $table->date('data_solicitacao');
            $table->timestamps();
        });

        // Adiciona a coluna de geometria usando PostGIS.
        DB::statement('ALTER TABLE processos_licenciamento ADD COLUMN geometria GEOMETRY(POLYGON, 4326)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processos_licenciamento');
    }
};