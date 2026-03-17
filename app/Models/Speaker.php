<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    // ── Scopes ────────────────────────────────

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

    // ── Relacionamentos ───────────────────────

    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'curso_speaker');
    }

    // ── Accessors ─────────────────────────────

    public function getFotoUrlAttribute(): ?string
    {
        if (! $this->foto) {
            return null;
        }
        return Storage::url($this->foto);
    }

    public function getInicialAttribute(): string
    {
        return strtoupper(mb_substr($this->nome, 0, 1));
    }
}