<?php

namespace App\Services;

use App\Jobs\EnviarEmailConfirmacao;
use App\Jobs\NotificarComissao;
use App\Jobs\EnviarEmailAprovacao;
use App\Jobs\EnviarEmailRejeicao;
use App\Models\Comprovativo;
use App\Models\Inscricao;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InscricaoService
{
    // ─── Criação (etapa anterior) ─────────────

    public function criar(array $dados, UploadedFile $ficheiro): Inscricao
    {
        return DB::transaction(function () use ($dados, $ficheiro) {
            $inscricao = Inscricao::create([
                'numero'            => Inscricao::gerarNumero(),
                'nome_completo'     => $dados['nome_completo'],
                'email'             => $dados['email'],
                'telefone'          => $dados['telefone'],
                'instituicao'       => $dados['instituicao'],
                'cargo'             => $dados['cargo'],
                'categoria'         => $dados['categoria'],
                'tipo_participacao' => $dados['tipo_participacao'],
                'status'            => 'pendente',
                'user_id'           => auth()->id(),
            ]);

            $path = $this->salvarFicheiro($ficheiro, $inscricao->numero);

            Comprovativo::create([
                'inscricao_id'  => $inscricao->id,
                'nome_original' => $ficheiro->getClientOriginalName(),
                'path'          => $path,
                'mime_type'     => $ficheiro->getMimeType(),
                'tamanho'       => $ficheiro->getSize(),
                'hash'          => hash_file('sha256', $ficheiro->getRealPath()),
                'status'        => 'pendente',
            ]);

            EnviarEmailConfirmacao::dispatch($inscricao)->onQueue('emails');
            NotificarComissao::dispatch($inscricao)->onQueue('emails');

            return $inscricao;
        });
    }

    // ─── Aprovação ────────────────────────────

    public function aprovar(Inscricao $inscricao): void
    {
        DB::transaction(function () use ($inscricao) {
            $inscricao->update([
                'status'       => 'aprovada',
                'avaliado_por' => Auth::id(),
                'avaliado_em'  => now(),
            ]);

            // Marcar comprovativo como aceite
            $inscricao->comprovativo?->update([
                'status'      => 'aceite',
                'revisto_por' => Auth::id(),
                'revisto_em'  => now(),
            ]);

            EnviarEmailAprovacao::dispatch($inscricao)->onQueue('emails');
        });
    }

    // ─── Rejeição ─────────────────────────────

    public function rejeitar(Inscricao $inscricao, string $motivo): void
    {
        DB::transaction(function () use ($inscricao, $motivo) {
            $inscricao->update([
                'status'           => 'rejeitada',
                'motivo_rejeicao'  => $motivo,
                'avaliado_por'     => Auth::id(),
                'avaliado_em'      => now(),
            ]);

            $inscricao->comprovativo?->update([
                'status'      => 'rejeitado',
                'revisto_por' => Auth::id(),
                'revisto_em'  => now(),
            ]);

            EnviarEmailRejeicao::dispatch($inscricao)->onQueue('emails');
        });
    }

    // ─── Upload privado ───────────────────────

    private function salvarFicheiro(UploadedFile $ficheiro, string $numero): string
    {
        $ano       = now()->year;
        $extensao  = $ficheiro->getClientOriginalExtension();
        $nome      = "{$numero}-" . time() . ".{$extensao}";

        return $ficheiro->storeAs("comprovativos/{$ano}", $nome, 'private');
    }
}