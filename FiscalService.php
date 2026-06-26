<?php

namespace App\Services\AI;

use App\Services\AI\Contracts\FiscalInterface;

class FiscalService implements FiscalInterface
{
    public function sugerirEnquadramento(array $dadosInfracao): array
    {
        return ['artigo' => 'Art. 25, Lei 9.605/1998', 'descricao' => 'Descrição do enquadramento sugerido.'];
    }

    public function calcularMulta(array $parametros): float
    {
        return 5000.00;
    }
}