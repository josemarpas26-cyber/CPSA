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

    /**
     * URL de download seguro para o comprovativo.
     * Apenas utilizadores autenticados com permissão podem aceder.
     *
     * O parâmetro $minutos é mantido na assinatura para compatibilidade futura
     * (ex.: se se migrar para URLs assinadas com expiração via S3 ou similar).
     */
    public function urlTemporaria(int $minutos = 5): string
    {
        return route('comprovativo.download', ['comprovativo' => $this->id]);
    }

    /** Tamanho formatado para UI */
    public function getTamanhoFormatadoAttribute(): string
    {
        $bytes = $this->tamanho;
        if ($bytes < 1024) {
            return "{$bytes} B";
        }
        if ($bytes < 1_048_576) {
            return round($bytes / 1024, 1) . ' KB';
        }
        return round($bytes / 1_048_576, 1) . ' MB';
    }
}