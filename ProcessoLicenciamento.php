<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessoLicenciamento extends Model
{
    use HasFactory, Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'processos_licenciamento';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function analista(): BelongsTo
    {
        return $this->belongsTo(User::class, 'analista_id');
    }

    /**
     * Define a relação com os documentos do processo.
     */
    public function documentos(): HasMany
    {
        // Assumindo que teremos um model 'ProcessoDocumento'
        return $this->hasMany(ProcessoDocumento::class);
    }

    public function historico(): HasMany
    {
        // Os logs de auditoria já são registrados pelo trait Auditable.
        // Esta relação pode ser usada para comentários ou eventos manuais.
        return $this->hasMany(AuditLog::class, 'auditable_id')->where('auditable_type', self::class);
    }
}