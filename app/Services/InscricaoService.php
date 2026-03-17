<?php

namespace App\Services;

use App\Jobs\EnviarEmailConfirmacao;
use App\Jobs\NotificarComissao;
use App\Jobs\EnviarEmailAprovacao;
use App\Jobs\EnviarEmailRejeicao;
use App\Models\Comprovativo;
use App\Models\Inscricao;
use App\Models\InscricaoCurso;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InscricaoService
{
    // ── Criação ───────────────────────────────

    public function criar(array $dados, UploadedFile $ficheiro): Inscricao
    {
        return DB::transaction(function () use ($dados, $ficheiro) {
            $inscricao = Inscricao::create([
                'numero'             => Inscricao::gerarNumero(),
                'full_name'          => $dados['full_name'],
                'gender'             => $dados['gender'],
                'date_of_birth'      => $dados['date_of_birth'],
                'nationality'        => $dados['nationality'],
                'document_number'    => $dados['document_number'],
                'profession'         => $dados['profession'],
                'institution'        => $dados['institution'],
                'category'           => $dados['category'],
                'phone'              => $dados['phone'],
                'email'              => $dados['email'],
                'province'           => $dados['province'],
                'participation_mode' => $dados['participation_mode'],
                'observations'       => $dados['observations'] ?? null,
                'status'             => 'pendente',
                'user_id'            => auth()->id(),
            ]);

            // Ligar ao curso escolhido
            InscricaoCurso::create([
                'inscricao_id' => $inscricao->id,
                'curso_id'     => $dados['curso_id'],
            ]);

            // Guardar comprovativo
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

    // ── Aprovação ─────────────────────────────

    public function aprovar(Inscricao $inscricao): void
    {
        DB::transaction(function () use ($inscricao) {
            $inscricao->update([
                'status'       => 'aprovada',
                'avaliado_por' => Auth::id(),
                'avaliado_em'  => now(),
            ]);

            $inscricao->comprovativo?->update([
                'status'      => 'aceite',
                'revisto_por' => Auth::id(),
                'revisto_em'  => now(),
            ]);

            EnviarEmailAprovacao::dispatch($inscricao)->onQueue('emails');
        });
    }

    // ── Rejeição ──────────────────────────────

    public function rejeitar(Inscricao $inscricao, string $motivo): void
    {
        DB::transaction(function () use ($inscricao, $motivo) {
            $inscricao->update([
                'status'          => 'rejeitada',
                'motivo_rejeicao' => $motivo,
                'avaliado_por'    => Auth::id(),
                'avaliado_em'     => now(),
            ]);

            $inscricao->comprovativo?->update([
                'status'      => 'rejeitado',
                'revisto_por' => Auth::id(),
                'revisto_em'  => now(),
            ]);

            EnviarEmailRejeicao::dispatch($inscricao)->onQueue('emails');
        });
    }

    // ── Upload privado ────────────────────────

    private function salvarFicheiro(UploadedFile $ficheiro, string $numero): string
    {
        $ano      = now()->year;
        $extensao = $ficheiro->getClientOriginalExtension();
        $nome     = "{$numero}-" . time() . ".{$extensao}";

        return $ficheiro->storeAs("comprovativos/{$ano}", $nome, 'private');
    }
}