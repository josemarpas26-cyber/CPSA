<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Comprovativo extends Model
{
    protected $fillable = [
        'inscricao_id',
        'nome_original',
        'path',
        'mime_type',
        'tamanho',
        'hash',
        'status',
        'revisto_por',
        'revisto_em',
    ];

    protected $casts = [
        'revisto_em' => 'datetime',
        'tamanho'    => 'integer',
    ];

    public function inscricao(): BelongsTo
    {
        return $this->belongsTo(Inscricao::class);
    }

    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisto_por');
    }

    /** URL temporária para visualização segura (somente admin) */
    public function urlTemporaria(): string
    {
        return route('comprovativo.download', ['comprovativo' => $this->id]);
    }

    /** Tamanho formatado para UI */
    public function getTamanhoFormatadoAttribute(): string
    {
        $bytes = $this->tamanho;
        if ($bytes < 1024) return "{$bytes} B";
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }
}