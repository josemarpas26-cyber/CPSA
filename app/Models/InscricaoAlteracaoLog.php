<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InscricaoAlteracaoLog extends Model
{
    protected $table = 'inscricao_alteracao_logs';

    public $timestamps = false;

    protected $fillable = [
        'inscricao_id',
        'editor_id',
        'campo',
        'valor_anterior',
        'valor_novo',
        'editado_em',
    ];

    protected $casts = [
        'editado_em' => 'datetime',
    ];

    public function inscricao(): BelongsTo
    {
        return $this->belongsTo(Inscricao::class);
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
