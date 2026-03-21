<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programa_actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->enum('tipo', [
                'workshop',
                'palestra',
                'mesa-redonda',
                'simposio',
                'exposicao',
                'casos-clinicos',
                'abertura',
                'encerramento',
                'outro',
            ])->default('outro');
            $table->string('sala', 150)->nullable();
            $table->date('dia'); // 2026-08-13, 2026-08-14, 2026-08-15
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->boolean('ativo')->default(true);
            $table->unsignedInteger('ordem')->default(0);
            $table->timestamps();

            $table->index(['dia', 'ativo']);
            $table->index(['dia', 'hora_inicio']);
        });

        // Pivot: actividade ←→ speaker
        Schema::create('actividade_speaker', function (Blueprint $table) {
            $table->foreignId('actividade_id')
                  ->constrained('programa_actividades')
                  ->cascadeOnDelete();
            $table->foreignId('speaker_id')
                  ->constrained('speakers')
                  ->cascadeOnDelete();
            $table->primary(['actividade_id', 'speaker_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividade_speaker');
        Schema::dropIfExists('programa_actividades');
    }
};