<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProgramaActividade extends Model
{
    protected $table = 'programa_actividades';

    protected $fillable = [
        'nome',
        'descricao',
        'tipo',
        'sala',
        'dia',
        'hora_inicio',
        'hora_fim',
        'ativo',
        'ordem',
    ];

    protected $casts = [
        'dia'  => 'date',
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    // ── Relacionamentos ───────────────────────

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(
        Speaker::class,
        'actividade_speaker',
        'actividade_id', // FK da tabela pivot para este model
        'speaker_id'     // FK para speakers
);
    }

    // ── Scopes ────────────────────────────────

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('hora_inicio')->orderBy('ordem');
    }

    public function scopeDia($query, string $dia)
    {
        return $query->where('dia', $dia);
    }

    // ── Accessors ─────────────────────────────

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'workshop'       => 'Workshop',
            'palestra'       => 'Palestra',
            'mesa-redonda'   => 'Mesa Redonda',
            'simposio'       => 'Simpósio',
            'exposicao'      => 'Exposição',
            'casos-clinicos' => 'Casos Clínicos',
            'abertura'       => 'Sessão de Abertura',
            'encerramento'   => 'Sessão de Encerramento',
            'outro'          => 'Outro',
            default          => ucfirst($this->tipo),
        };
    }

    public function getTipoColorAttribute(): string
    {
        return match ($this->tipo) {
            'workshop'       => '#1d4ed8',
            'palestra'       => '#0f766e',
            'mesa-redonda'   => '#6d28d9',
            'simposio'       => '#b45309',
            'exposicao'      => '#be123c',
            'casos-clinicos' => '#0369a1',
            'abertura'       => '#059669',
            'encerramento'   => '#475569',
            default          => '#3d5080',
        };
    }

    public function getTipoBgAttribute(): string
    {
        return match ($this->tipo) {
            'workshop'       => '#eff6ff',
            'palestra'       => '#f0fdfa',
            'mesa-redonda'   => '#f5f3ff',
            'simposio'       => '#fffbeb',
            'exposicao'      => '#fff1f2',
            'casos-clinicos' => '#e0f2fe',
            'abertura'       => '#ecfdf5',
            'encerramento'   => '#f8faff',
            default          => '#f4f7ff',
        };
    }

    public function getHorarioLabelAttribute(): string
    {
        return substr($this->hora_inicio, 0, 5) . ' – ' . substr($this->hora_fim, 0, 5);
    }

    public static function tipos(): array
    {
        return [
            'workshop'       => 'Workshop',
            'palestra'       => 'Palestra',
            'mesa-redonda'   => 'Mesa Redonda',
            'simposio'       => 'Simpósio',
            'exposicao'      => 'Exposição',
            'casos-clinicos' => 'Casos Clínicos',
            'abertura'       => 'Sessão de Abertura',
            'encerramento'   => 'Sessão de Encerramento',
            'outro'          => 'Outro',
        ];
    }

    public static function dias(): array
    {
        return [
            '2026-08-13' => 'Quarta, 13 de Agosto',
            '2026-08-14' => 'Quinta, 14 de Agosto',
            '2026-08-15' => 'Sexta, 15 de Agosto',
        ];
    }
}