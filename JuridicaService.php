<?php

namespace App\Services\AI;

use App\Services\AI\Contracts\JuridicaInterface;

class JuridicaService implements JuridicaInterface
{
    public function sugerirFundamentacao(string $tipoAto, array $contexto): string
    {
        return 'Com base na Lei 9.605/1998 e no Decreto 6.514/2008, a fundamentação legal é...';
    }
}