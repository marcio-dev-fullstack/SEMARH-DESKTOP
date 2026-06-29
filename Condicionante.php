<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Condicionante extends Model
{
    use HasFactory;

    protected $fillable = [
        'licenca_id',
        'descricao',
        'status',
        'prazo',
    ];

    /**
     * A condicionante pertence a uma licença.
     */
    public function licenca(): BelongsTo
    {
        return $this->belongsTo(Licenca::class);
    }
}