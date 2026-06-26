<?php

namespace App\Services\AI\Contracts;

interface JuridicaInterface
{
    public function sugerirFundamentacao(string $tipoAto, array $contexto): string;
}