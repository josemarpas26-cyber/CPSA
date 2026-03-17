<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Inscricao extends Model
{
    use SoftDeletes;

    protected $table = 'inscricoes';

    protected $fillable = [
        'numero',
        // Dados pessoais (novo esquema)
        'full_name',
        'gender',
        'date_of_birth',
        'nationality',
        'document_number',
        'profession',
        'institution',
        'category',
        'phone',
        'email',
        'province',
        'participation_mode',
        'observations',
        // Workflow
        'status',
        'avaliado_por',
        'avaliado_em',
        'motivo_rejeicao',
        'user_id',
        'presente',
        'checkin_em',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'avaliado_em'   => 'datetime',
        'checkin_em'    => 'datetime',
        'presente'      => 'boolean',
    ];

    // ── Labels para UI ────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pendente'   => 'Pendente',
            'em_analise' => 'Em Análise',
            'aprovada'   => 'Aprovada',
            'rejeitada'  => 'Rejeitada',
            default      => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pendente'   => 'warning',
            'em_analise' => 'secondary',
            'aprovada'   => 'success',
            'rejeitada'  => 'danger',
            default      => 'gray',
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'profissional' => 'Profissional',
            'estudante'    => 'Estudante',
            'orador'       => 'Orador',
            'convidado'    => 'Convidado',
            'imprensa'     => 'Imprensa',
            default        => $this->category,
        };
    }

    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'masculino' => 'Masculino',
            'feminino'  => 'Feminino',
            'outro'     => 'Outro',
            default     => $this->gender,
        };
    }

    public function getParticipationModeLabelAttribute(): string
    {
        return match ($this->participation_mode) {
            'presencial' => 'Presencial',
            'online'     => 'Online',
            default      => $this->participation_mode,
        };
    }

    /**
     * Alias de compatibilidade: muitas views usam $inscricao->nome_completo
     */
    public function getNomeCompletoAttribute(): string
    {
        return $this->full_name;
    }

    /**
     * Alias de compatibilidade: muitas views usam $inscricao->categoria_label
     */
    public function getCategoriaLabelAttribute(): string
    {
        return $this->category_label;
    }

    // ── Geração do número único ───────────────

    public static function gerarNumero(): string
    {
        return DB::transaction(function () {
            $ano     = now()->year;
            $prefixo = "CPSA-{$ano}-";

            $ultimo = self::withTrashed()
                ->where('numero', 'like', "{$prefixo}%")
                ->lockForUpdate()
                ->orderByDesc('id')
                ->value('numero');

            $sequencia = $ultimo
                ? (int) substr($ultimo, strlen($prefixo)) + 1
                : 1;

            return $prefixo . str_pad($sequencia, 4, '0', STR_PAD_LEFT);
        });
    }

    // ── Relacionamentos ───────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function avaliador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'avaliado_por');
    }

    public function comprovativos(): HasMany
    {
        return $this->hasMany(Comprovativo::class);
    }

    public function comprovativo(): HasOne
    {
        return $this->hasOne(Comprovativo::class)->latestOfMany();
    }

    public function certificado(): HasOne
    {
        return $this->hasOne(Certificado::class);
    }

    public function alteracoes(): HasMany
    {
        return $this->hasMany(InscricaoAlteracaoLog::class)->orderByDesc('editado_em');
    }

    /** Curso escolhido (1 por inscrição) */
    public function inscricaoCurso(): HasOne
    {
        return $this->hasOne(InscricaoCurso::class);
    }

    public function getCursoAttribute(): ?Curso
    {
        return $this->inscricaoCurso?->curso;
    }

    // ── Scopes ────────────────────────────────

    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeEmAnalise($query)
    {
        return $query->where('status', 'em_analise');
    }

    public function scopeAprovada($query)
    {
        return $query->where('status', 'aprovada');
    }

    public function scopeRejeitada($query)
    {
        return $query->where('status', 'rejeitada');
    }
}