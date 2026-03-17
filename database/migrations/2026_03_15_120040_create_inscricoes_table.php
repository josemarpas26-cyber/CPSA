<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();

            // Número único de inscrição: CPSA-2025-0001
            $table->string('numero', 20)->unique();

            // ── Dados pessoais ───────────────────────────
            $table->string('full_name'); // substitui nome_completo
            $table->enum('gender', ['masculino', 'feminino', 'outro']);
            $table->date('date_of_birth');
            $table->string('nationality', 100);
            $table->string('document_number', 50)->unique();
            $table->string('profession', 150);
            $table->string('institution');
            $table->string('email')->index();
            $table->string('phone', 20);

            // ── Categoria e participação ─────────────────
            $table->enum('category', [
                'profissional',
                'estudante',
                'orador',
                'convidado',
                'imprensa',
            ]);
            $table->string('province', 100);
            $table->enum('participation_mode', ['presencial', 'online']);
            $table->text('observations')->nullable();

            // ── Status do fluxo ─────────────────────────
            $table->enum('status', [
                'pendente',
                'em_analise',
                'aprovada',
                'rejeitada',
            ])->default('pendente')->index();

            // ── Avaliação pela comissão ─────────────────
            $table->foreignId('avaliado_por')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('avaliado_em')->nullable();
            $table->text('motivo_rejeicao')->nullable();

            // ── Vínculo com usuário ─────────────────────
            $table->foreignId('user_id')->nullable()
                  ->constrained()->nullOnDelete();

            // ── Controlo de presença ────────────────────
            $table->boolean('presente')->default(false);
            $table->timestamp('checkin_em')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscricoes');
    }
};