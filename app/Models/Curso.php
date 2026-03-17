<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nome',
        'descricao',
        'sala',
        'dia',
        'hora_inicio',
        'hora_fim',
        'vagas',
        'ativo',
        'ordem',
    ];

    protected $casts = [
        'dia'        => 'date',
        'hora_inicio' => 'string',
        'hora_fim'    => 'string',
        'ativo'      => 'boolean',
        'vagas'      => 'integer',
        'ordem'      => 'integer',
    ];

    // ── Relacionamentos ───────────────────────

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'curso_speaker');
    }

    public function inscricoes(): HasMany
    {
        return $this->hasMany(InscricaoCurso::class);
    }

    // ── Scopes ────────────────────────────────

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('dia')->orderBy('hora_inicio')->orderBy('ordem');
    }

    // ── Accessors ─────────────────────────────

    /**
     * Número de inscrições já efectuadas neste curso.
     */
    public function getInscritosCountAttribute(): int
    {
        return $this->inscricoes()->count();
    }

    /**
     * Vagas disponíveis restantes (null = ilimitado).
     */
    public function getVagasDisponiveisAttribute(): ?int
    {
        if ($this->vagas === null) {
            return null;
        }
        return max(0, $this->vagas - $this->inscritos_count);
    }

    /**
     * Indica se o curso ainda tem vagas.
     */
    public function getTemVagasAttribute(): bool
    {
        if ($this->vagas === null) {
            return true;
        }
        return $this->inscritos_count < $this->vagas;
    }

    /**
     * Label formatado do horário: "Seg, 14/06 · 09h00–11h00"
     */
    public function getHorarioLabelAttribute(): string
    {
        $dia    = $this->dia->isoFormat('ddd, DD/MM');
        $inicio = substr($this->hora_inicio, 0, 5);
        $fim    = substr($this->hora_fim, 0, 5);
        return "{$dia} · {$inicio}–{$fim}";
    }
}