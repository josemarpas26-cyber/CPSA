<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inscricao_id')
                ->unique()                          // 1 certificado por inscrição
                ->constrained('inscricoes')        // nome correto da tabela
                ->cascadeOnDelete();

            $table->string('path')->nullable();       // PDF gerado
            $table->string('codigo_verificacao', 32)->unique(); // UUID curto
            $table->timestamp('gerado_em')->nullable();
            $table->timestamp('enviado_em')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};