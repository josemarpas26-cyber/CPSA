<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificado extends Model
{
    protected $fillable = [
        'inscricao_id',
        'path',
        'codigo_verificacao',
        'gerado_em',
        'enviado_em',
    ];

    protected $casts = [
        'gerado_em'  => 'datetime',
        'enviado_em' => 'datetime',
    ];

    public function inscricao(): BelongsTo
    {
        return $this->belongsTo(Inscricao::class);
    }
}