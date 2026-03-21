<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeria', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('foto');
            $table->string('foto_alt', 255)->nullable();
            $table->enum('categoria', [
                'mesas-redondas',
                'workshops',
                'conferencias',
                'casos-clinicos',
                'palestras',
                'temas-livres',
                'outro',
            ])->default('outro');
            $table->date('data_publicacao');
            $table->boolean('ativo')->default(true);
            $table->unsignedInteger('ordem')->default(0);
            $table->foreignId('criado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('ativo');
            $table->index('categoria');
            $table->index(['ativo', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeria');
    }
};