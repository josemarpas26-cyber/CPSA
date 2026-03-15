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

            // Dados pessoais
            $table->string('nome_completo');
            $table->string('email')->index();
            $table->string('telefone', 20);
            $table->string('instituicao');
            $table->string('cargo');

            // Classificação
            $table->enum('categoria', [
                'medico',
                'enfermeiro',
                'psicologo',
                'estudante',
                'outro',
            ]);

            $table->enum('tipo_participacao', [
                'presencial',
                'online',
            ]);

            // Valores (AOA)
            $table->decimal('valor', 10, 2)->default(0);

            // Status do fluxo
            $table->enum('status', [
                'pendente',
                'em_analise',
                'aprovada',
                'rejeitada',
            ])->default('pendente')->index();

            // Avaliação pela comissão
            $table->foreignId('avaliado_por')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('avaliado_em')->nullable();
            $table->text('motivo_rejeicao')->nullable();

            // Vínculo com user (se criou conta)
            $table->foreignId('user_id')->nullable()
                  ->constrained()->nullOnDelete();

            // Controlo de presença
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