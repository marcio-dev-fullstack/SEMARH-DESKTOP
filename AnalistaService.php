<?php

namespace App\Services\AI;

use App\Services\AI\Contracts\AnalistaInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnalistaService implements AnalistaInterface
{
    public function analisarDocumentos(array $documentos): array
    {
        // Lógica aprimorada para chamar uma API de IA externa
        try {
            $response = Http::withToken(config('services.ai_analista.key'))
                ->timeout(30)
                ->post(config('services.ai_analista.endpoint'), [
                    'documentos' => $documentos,
                ]);

            if ($response->successful()) {
                return $response->json(); // Retorna a resposta da IA
            }

            // Em caso de falha na API, retorna um erro estruturado
            Log::error('Falha na comunicação com a API do Analista de IA.', ['status' => $response->status()]);
            return ['error' => 'Serviço de análise indisponível no momento.', 'details' => $response->body()];

        } catch (\Exception $e) {
            Log::critical('Exceção ao chamar a API do Analista de IA.', ['message' => $e->getMessage()]);
            return ['error' => 'Ocorreu um erro crítico ao tentar analisar os documentos.'];
        }
    }

    public function identificarPendencias(array $dadosProcesso): array
    {
        // Implementação de exemplo: chama o método principal com os dados formatados
        $analise = $this->analisarDocumentos($dadosProcesso['documentos'] ?? []);

        return ['status' => 'ok', 'pendencias' => $analise['pendencias'] ?? []];
    }
}