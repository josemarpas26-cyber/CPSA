<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscricao_alteracao_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscricao_id')->constrained('inscricoes')->cascadeOnDelete();
            $table->foreignId('editor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('campo', 100);
            $table->text('valor_anterior')->nullable();
            $table->text('valor_novo')->nullable();
            $table->timestamp('editado_em');

            $table->index(['inscricao_id', 'editado_em']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscricao_alteracao_logs');
    }
};
