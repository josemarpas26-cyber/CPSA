<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->text('descricao')->nullable();

            // Local e horário
            $table->string('sala', 150);
            $table->date('dia');
            $table->time('hora_inicio');
            $table->time('hora_fim');

            // Vagas (null = ilimitado)
            $table->unsignedInteger('vagas')->nullable();

            // Estado
            $table->boolean('ativo')->default(true);

            // Ordem de exibição no formulário
            $table->unsignedInteger('ordem')->default(0);

            $table->timestamps();

            $table->index(['dia', 'ativo']);
            $table->index('ordem');
        });

        // Pivot: curso ←→ palestrante
        Schema::create('curso_speaker', function (Blueprint $table) {
            $table->foreignId('curso_id')
                  ->constrained('cursos')
                  ->cascadeOnDelete();
            $table->foreignId('speaker_id')
                  ->constrained('speakers')
                  ->cascadeOnDelete();
            $table->primary(['curso_id', 'speaker_id']);
        });

        // Pivot: inscricao ←→ curso (1 por inscrição)
        Schema::create('inscricao_curso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscricao_id')
                  ->unique()
                  ->constrained('inscricoes')
                  ->cascadeOnDelete();
            $table->foreignId('curso_id')
                  ->constrained('cursos')
                  ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscricao_curso');
        Schema::dropIfExists('curso_speaker');
        Schema::dropIfExists('cursos');
    }
};