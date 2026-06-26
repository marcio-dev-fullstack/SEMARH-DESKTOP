<?php

namespace Database\Seeders;

use App\Models\ProcessoDocumento;
use Illuminate\Database\Seeder;

class ProcessoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Documentos para o Processo 1
        ProcessoDocumento::firstOrCreate(
            [
                'processo_licenciamento_id' => 1,
                'name' => 'Memorial Descritivo.pdf',
            ],
            [
                'user_id' => 2, // Carlos Ferreira
                'path' => 'processos/1/documentos/memorial_descritivo.pdf',
            ]
        );

        ProcessoDocumento::firstOrCreate(
            [
                'processo_licenciamento_id' => 1,
                'name' => 'Projeto Basico.pdf',
            ],
            [
                'user_id' => 2, // Carlos Ferreira
                'path' => 'processos/1/documentos/projeto_basico.pdf',
            ]
        );
    }
}