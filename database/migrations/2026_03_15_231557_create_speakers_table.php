<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('especialidade', 255);
            $table->string('instituicao', 255)->nullable();
            $table->string('pais', 100)->default('Angola');
            $table->text('biografia')->nullable();
            $table->string('email', 320)->nullable();
            $table->string('linkedin', 500)->nullable();
            $table->string('twitter', 500)->nullable();
            $table->string('foto', 500)->nullable();
            $table->boolean('destaque')->default(false); // aparece na home
            $table->integer('ordem')->default(0);        // ordem de exibição
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->index('ativo');
            $table->index('destaque');
            $table->index('ordem');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};