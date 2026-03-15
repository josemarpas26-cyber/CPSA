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
        'nome_completo',
        'email',
        'telefone',
        'instituicao',
        'cargo',
        'categoria',
        'tipo_participacao',
        'valor',
        'status',
        'avaliado_por',
        'avaliado_em',
        'motivo_rejeicao',
        'user_id',
        'presente',
        'checkin_em',
    ];

    protected $casts = [
        'avaliado_em' => 'datetime',
        'checkin_em'  => 'datetime',
        'presente'    => 'boolean',
        'valor'       => 'decimal:2',
    ];

    // ─── Labels para UI ───────────────────────

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

    public function getCategoriaLabelAttribute(): string
    {
        return match ($this->categoria) {
            'medico'     => 'Médico(a)',
            'enfermeiro' => 'Enfermeiro(a)',
            'psicologo'  => 'Psicólogo(a)',
            'estudante'  => 'Estudante',
            'outro'      => 'Outro',
            default      => $this->categoria,
        };
    }

    // ─── Geração do número único ──────────────

    /**
     * Gera o próximo número de inscrição de forma atómica,
     * evitando race conditions em acessos simultâneos.
     */
    public static function gerarNumero(): string
    {
        return DB::transaction(function () {
            $ano     = now()->year;
            $prefixo = "CPSA-{$ano}-";

            // lockForUpdate previne race conditions: apenas uma transacção
            // pode ler e incrementar o contador de cada vez.
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

    // ─── Relacionamentos ──────────────────────

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

    // ─── Scopes ───────────────────────────────

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