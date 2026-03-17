<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Participant\InscricaoController as ParticipantInscricao;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InscricaoController as AdminInscricao;
use App\Http\Controllers\Admin\CertificadoController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\ExportacaoController;
use App\Http\Controllers\Admin\UtilizadorController;
use App\Http\Controllers\Admin\AdminSpeakerController;
use App\Http\Controllers\ComprovativoController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SpeakerController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────
// PORTAL PÚBLICO
// ─────────────────────────────────────────
Route::get('/', fn () => view('participant.index'))->name('home');

Route::get('/palestrantes', [SpeakerController::class, 'index'])->name('speakers.index');
Route::get('/palestrantes/{speaker}', [SpeakerController::class, 'show'])->name('speakers.show');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])
     ->name('newsletter.subscribe');
Route::get('/newsletter/cancelar', [NewsletterController::class, 'unsubscribe'])
     ->name('newsletter.unsubscribe');

// Download seguro de comprovativos (auth obrigatório)
Route::middleware('auth')->group(function () {
    Route::get('/comprovativo/{comprovativo}/download', [ComprovativoController::class, 'download'])
        ->name('comprovativo.download');
});

// ─── Autenticação ─────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])->middleware('throttle:login');
    Route::get('/registro',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Inscrição pública ────────────────────
Route::get('/inscricao',         [ParticipantInscricao::class, 'create'])->name('inscricao.create');
Route::post('/inscricao',        [ParticipantInscricao::class, 'store'])
    ->middleware('throttle:inscricao')
    ->name('inscricao.store');
Route::get('/inscricao/sucesso', [ParticipantInscricao::class, 'sucesso'])->name('inscricao.sucesso');

// ─── Área do participante ──────────────────
Route::middleware('auth')->prefix('minha-inscricao')->name('participant.')->group(function () {
    Route::get('/',            [ParticipantInscricao::class, 'show'])->name('minha-inscricao');
    Route::get('/certificado', [ParticipantInscricao::class, 'downloadCertificado'])
         ->name('certificado.download');
});

// ─────────────────────────────────────────
// PAINEL ADMIN
// ─────────────────────────────────────────
Route::middleware(['auth', 'role:admin,organizador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ─── Inscrições ─────────────────────────────────
        Route::get('/inscricoes',                          [AdminInscricao::class, 'index'])->name('inscricoes.index');
        Route::get('/inscricoes/{inscricao}',              [AdminInscricao::class, 'show'])->name('inscricoes.show');
        Route::patch('/inscricoes/{inscricao}/dados',      [AdminInscricao::class, 'atualizarDados'])->name('inscricoes.atualizar-dados');
        Route::patch('/inscricoes/{inscricao}/aprovar',    [AdminInscricao::class, 'aprovar'])->name('inscricoes.aprovar');
        Route::patch('/inscricoes/{inscricao}/rejeitar',   [AdminInscricao::class, 'rejeitar'])->name('inscricoes.rejeitar');
        Route::patch('/inscricoes/{inscricao}/em-analise', [AdminInscricao::class, 'marcarEmAnalise'])->name('inscricoes.em-analise');
        Route::patch('/inscricoes/{inscricao}/checkin',    [AdminInscricao::class, 'checkin'])->name('inscricoes.checkin');

        // ─── Exportação ─────────────────────────────────
        Route::get('/exportar/excel',    [ExportacaoController::class, 'excel'])->name('exportar.excel');
        Route::get('/exportar/csv',      [ExportacaoController::class, 'csv'])->name('exportar.csv');
        Route::get('/exportar/presenca', [ExportacaoController::class, 'presenca'])->name('exportar.presenca');

        // ─── Certificados ────────────────────────────────
        Route::get('/certificados',                        [CertificadoController::class, 'index'])->name('certificados.index');
        Route::post('/certificados/{inscricao}/gerar',     [CertificadoController::class, 'gerar'])->name('certificados.gerar');
        Route::post('/certificados/gerar-todos',           [CertificadoController::class, 'gerarTodos'])->name('certificados.gerar-todos');
        Route::get('/certificados/{certificado}/download', [CertificadoController::class, 'download'])->name('certificados.download');

        // ─── Gestão apenas para admin ────────────────────
        Route::middleware('role:admin')->group(function () {

            // Cursos
            Route::resource('cursos', CursoController::class)->except(['show']);
            Route::patch('cursos/{curso}/toggle-ativo', [CursoController::class, 'toggleAtivo'])
                 ->name('cursos.toggle-ativo');

            // Palestrantes
            Route::resource('speakers', AdminSpeakerController::class)->except(['show']);
            Route::patch('speakers/{speaker}/toggle-ativo', [AdminSpeakerController::class, 'toggleAtivo'])
                 ->name('speakers.toggle-ativo');
            Route::patch('speakers/{speaker}/toggle-destaque', [AdminSpeakerController::class, 'toggleDestaque'])
                 ->name('speakers.toggle-destaque');

            // Utilizadores
            Route::get('/utilizadores',  [UtilizadorController::class, 'index'])->name('utilizadores.index');
            Route::post('/utilizadores', [UtilizadorController::class, 'store'])->name('utilizadores.store');
        });
    });