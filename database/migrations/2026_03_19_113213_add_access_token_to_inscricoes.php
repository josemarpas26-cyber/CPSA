<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adiciona access_token único a cada inscrição.
 * Participantes acedem à sua área via link único enviado por email —
 * sem necessidade de criar conta ou fazer login.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->string('access_token', 64)
                  ->nullable()
                  ->unique()
                  ->after('numero')
                  ->comment('Token único enviado por email ao participante. Dispensa autenticação.');
        });
    }

    public function down(): void
    {
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->dropColumn('access_token');
        });
    }
};