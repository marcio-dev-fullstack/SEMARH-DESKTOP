<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria o usuário Administrador
        User::firstOrCreate(
            ['email' => 'marcio.oliveira@semarh.gov.br'],
            [
                'name' => 'Márcio Rodrigues',
                'password' => Hash::make('password'),
                'role' => 'Administrador',
                'status' => 'Ativo',
                'cpf' => '000.000.000-00',
                'celular' => '(62) 99646-6033',
                'matricula' => 'ADM001',
            ]
        );

        // Cria usuários Analistas
        User::firstOrCreate(
            ['email' => 'carlos.ferreira@semarh.gov.br'],
            [
                'name' => 'Carlos Ferreira',
                'password' => Hash::make('password'),
                'role' => 'Analista',
                'status' => 'Ativo',
                'cpf' => '111.222.333-44',
                'celular' => '(62) 91111-2222',
                'matricula' => '12345',
            ]
        );
    }
}