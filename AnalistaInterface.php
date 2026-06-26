<?php

namespace App\Services\AI\Contracts;

interface AnalistaInterface
{
    public function analisarDocumentos(array $documentos): array;
    public function identificarPendencias(array $dadosProcesso): array;
}