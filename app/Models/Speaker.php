<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';

    protected $fillable = [
        'nome',
        'especialidade',
        'instituicao',
        'pais',
        'biografia',
        'email',
        'linkedin',
        'twitter',
        'foto',
        'destaque',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'destaque' => 'boolean',
        'ativo'    => 'boolean',
        'ordem'    => 'integer',
    ];

    /* ── Scopes ───────────────────────────────────── */

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    /* ── Accessors ────────────────────────────────── */

    /**
     * URL pública da foto ou null se não tiver.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (! $this->foto) {
            return null;
        }
        return Storage::url($this->foto);
    }

    /**
     * Inicial do nome para o avatar placeholder.
     */
    public function getInicialAttribute(): string
    {
        return strtoupper(mb_substr($this->nome, 0, 1));
    }
}