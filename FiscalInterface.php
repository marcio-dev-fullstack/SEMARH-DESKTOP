<?php

namespace App\Services\AI\Contracts;

interface FiscalInterface
{
    public function sugerirEnquadramento(array $dadosInfracao): array;
    public function calcularMulta(array $parametros): float;
}