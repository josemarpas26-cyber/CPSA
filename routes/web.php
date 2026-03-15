<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Participant\InscricaoController as ParticipantInscricao;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InscricaoController as AdminInscricao;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComprovativoController;
// ─────────────────────────────────────────
// PORTAL PÚBLICO
// ─────────────────────────────────────────
Route::get('/', fn () => view('participant.index'))->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/comprovativo/{comprovativo}/download', [ComprovativoController::class, 'download'])
        ->name('comprovativo.download');
});
// Autenticação
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:login');
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Inscrição (público — não exige login)
Route::get('/inscricao',         [ParticipantInscricao::class, 'create'])->name('inscricao.create');
Route::post('/inscricao', [ParticipantInscricao::class, 'store'])
    ->middleware('throttle:inscricao')
    ->name('inscricao.store');
Route::get('/inscricao/sucesso', [ParticipantInscricao::class, 'sucesso'])->name('inscricao.sucesso');

// Área do participante (exige login)
Route::middleware('auth')->prefix('minha-inscricao')->name('participant.')->group(function () {
    Route::get('/', [ParticipantInscricao::class, 'show'])->name('minha-inscricao');
        // Dentro do grupo auth → participant:
   // Route::get('/minha-inscricao/certificado',
    Route::get('/certificado',
        [ParticipantInscricao::class, 'downloadCertificado']
        )->name('certificado.download');
});

// ─────────────────────────────────────────
// PAINEL ADMIN
// ─────────────────────────────────────────
Route::middleware(['auth', 'role:admin,organizador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Inscrições
        Route::get('/inscricoes',          [AdminInscricao::class, 'index'])->name('inscricoes.index');
        Route::get('/inscricoes/{inscricao}', [AdminInscricao::class, 'show'])->name('inscricoes.show');
        Route::patch('/inscricoes/{inscricao}/dados', [AdminInscricao::class, 'atualizarDados'])->name('inscricoes.atualizar-dados');
        Route::patch('/inscricoes/{inscricao}/aprovar',  [AdminInscricao::class, 'aprovar'])->name('inscricoes.aprovar');
        Route::patch('/inscricoes/{inscricao}/rejeitar', [AdminInscricao::class, 'rejeitar'])->name('inscricoes.rejeitar');

        // Exportação
        Route::get('/exportar/excel',    [\App\Http\Controllers\Admin\ExportacaoController::class, 'excel'])->name('exportar.excel');
        Route::get('/exportar/csv',      [\App\Http\Controllers\Admin\ExportacaoController::class, 'csv'])->name('exportar.csv');
        Route::get('/exportar/presenca', [\App\Http\Controllers\Admin\ExportacaoController::class, 'presenca'])->name('exportar.presenca');

        // Certificados
        Route::get('/certificados',                          [\App\Http\Controllers\Admin\CertificadoController::class, 'index'])->name('certificados.index');
        Route::post('/certificados/{inscricao}/gerar',       [\App\Http\Controllers\Admin\CertificadoController::class, 'gerar'])->name('certificados.gerar');
        Route::post('/certificados/gerar-todos',             [\App\Http\Controllers\Admin\CertificadoController::class, 'gerarTodos'])->name('certificados.gerar-todos');
   
        // Dentro do grupo admin, após certificados.gerar-todos:
        Route::get('/certificados/{certificado}/download',
            [\App\Http\Controllers\Admin\CertificadoController::class, 'download']
        )->name('certificados.download');
        });