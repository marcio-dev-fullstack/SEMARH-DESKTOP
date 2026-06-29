<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Licenca extends Model
{
    use HasFactory;

    protected $fillable = [
        'processo_licenciamento_id',
        'numero',
        'data_emissao',
        'data_validade',
    ];

    /**
     * A licença pertence a um processo de licenciamento.
     */
    public function processoLicenciamento(): BelongsTo
    {
        return $this->belongsTo(ProcessoLicenciamento::class);
    }

    /**
     * A licença possui várias condicionantes.
     */
    public function condicionantes(): HasMany
    {
        return $this->hasMany(Condicionante::class);
    }
}