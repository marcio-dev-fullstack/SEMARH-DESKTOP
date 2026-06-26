<?php

namespace Database\Seeders;

use App\Models\ProcessoLicenciamento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessoLicenciamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProcessoLicenciamento::firstOrCreate(
            ['protocolo' => '202601-12345'],
            [
                'nome_requerente' => 'Empresa Exemplo LTDA',
                'documento_requerente' => '12.345.678/0001-99',
                'email_requerente' => 'contato@empresaexemplo.com',
                'telefone_requerente' => '(62) 3201-1000',
                'tipo_licenca' => 'Licença de Operação (LO)',
                'descricao_atividade' => 'Operação de planta industrial para fabricação de produtos metálicos.',
                'status' => 'Em Análise Técnica',
                'localizacao' => DB::raw("ST_GeomFromText('POINT(-49.25 -16.68)', 4326)"),
                'analista_id' => 2, // ID de Carlos Ferreira
            ]
        );

        ProcessoLicenciamento::firstOrCreate(
            ['protocolo' => '202602-54321'],
            [
                'nome_requerente' => 'Construtora Futuro S.A.',
                'documento_requerente' => '98.765.432/0001-11',
                'email_requerente' => 'engenharia@construtorafuturo.com',
                'telefone_requerente' => '(62) 3202-2000',
                'tipo_licenca' => 'Licença de Instalação (LI)',
                'descricao_atividade' => 'Instalação de novo complexo residencial com 4 torres de apartamentos.',
                'status' => 'Aguardando Documentação',
                'localizacao' => DB::raw("ST_GeomFromText('POINT(-49.26 -16.67)', 4326)"),
                'analista_id' => null,
            ]
        );
    }
}