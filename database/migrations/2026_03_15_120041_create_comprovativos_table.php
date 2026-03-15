<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comprovativos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inscricao_id')
                  ->constrained('inscricoes')->cascadeOnDelete();

            $table->string('nome_original');          // nome do ficheiro original
            $table->string('path');                   // caminho em storage/app/private
            $table->string('mime_type', 50);
            $table->unsignedBigInteger('tamanho');    // bytes
            $table->string('hash', 64)->nullable();   // sha256 para integridade

            // Análise pelo admin
            $table->enum('status', [
                'pendente',
                'aceite',
                'rejeitado',
            ])->default('pendente');

            $table->foreignId('revisto_por')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('revisto_em')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comprovativos');
    }
};