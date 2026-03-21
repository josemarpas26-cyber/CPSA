<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Galeria extends Model
{
    protected $table = 'galeria';

    protected $fillable = [
        'titulo',
        'descricao',
        'foto',
        'foto_alt',
        'categoria',
        'data_publicacao',
        'ativo',
        'ordem',
        'criado_por',
    ];

    protected $casts = [
        'data_publicacao' => 'date',
        'ativo'           => 'boolean',
        'ordem'           => 'integer',
    ];

    // ── Relacionamentos ───────────────────────

    public function criador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    // ── Scopes ────────────────────────────────

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('ordem')->orderByDesc('data_publicacao');
    }

    public function scopeCategoria($query, string $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    // ── Accessors ─────────────────────────────

    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }
        return Storage::disk('public')->url($this->foto);
    }

    public function getCategoriaLabelAttribute(): string
    {
        return match ($this->categoria) {
            'mesas-redondas' => 'Mesas Redondas',
            'workshops'      => 'Workshops',
            'conferencias'   => 'Conferências',
            'casos-clinicos' => 'Casos Clínicos',
            'palestras'      => 'Palestras',
            'temas-livres'   => 'Temas Livres',
            'outro'          => 'Outro',
            default          => ucfirst($this->categoria),
        };
    }

    public static function categorias(): array
    {
        return [
            'mesas-redondas' => 'Mesas Redondas',
            'workshops'      => 'Workshops',
            'conferencias'   => 'Conferências',
            'casos-clinicos' => 'Casos Clínicos',
            'palestras'      => 'Palestras',
            'temas-livres'   => 'Temas Livres',
            'outro'          => 'Outro',
        ];
    }
}