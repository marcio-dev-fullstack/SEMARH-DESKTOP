<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProcessoLicenciamento extends Model
{
    use HasFactory;

    protected $table = 'processos_licenciamento';

    protected $fillable = [
        'cidadao_id',
        'tipo_licenca',
        'status',
        'data_solicitacao',
        'geometria',
    ];

    /**
     * O processo pertence a um cidadão (usuário).
     */
    public function cidadao(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cidadao_id');
    }

    /**
     * O processo pode gerar uma licença.
     */
    public function licenca(): HasOne
    {
        return $this->hasOne(Licenca::class);
    }
}