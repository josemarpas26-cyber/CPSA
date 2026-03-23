<?php

use App\Http\Controllers\Auth\AdminAuthController;
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
use App\Http\Controllers\GaleriaPublicController;
use App\Http\Controllers\ProgramaPublicController;
use App\Http\Controllers\Admin\AdminGaleriaController;
use App\Http\Controllers\Admin\AdminProgramaController;
// ═══════════════════════════════════════════════════════════════
//  PORTAL PÚBLICO — sem qualquer autenticação
// ═══════════════════════════════════════════════════════════════

// DEPOIS (passa pelo controller que carrega $cursos e $speakers)
Route::get('/', [ParticipantInscricao::class, 'index'])->name('home');

Route::get('/palestrantes',            [SpeakerController::class, 'index'])->name('speakers.index');
Route::get('/palestrantes/{speaker}',  [SpeakerController::class, 'show'])->name('speakers.show');

Route::post('/newsletter/subscribe',  [NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::get('/newsletter/cancelar',    [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// ── Inscrição pública (sem conta) ──────────────────────────────
Route::get('/inscricao',         [ParticipantInscricao::class, 'create'])->name('inscricao.create');
Route::get('/inscricao/sucesso', [ParticipantInscricao::class, 'sucesso'])->name('inscricao.sucesso');
Route::post('/inscricao', [ParticipantInscricao::class, 'store'])
    ->middleware('throttle:inscricao')
    ->name('inscricao.store');

Route::get('/galeria', [GaleriaPublicController::class, 'index'])
    ->name('galeria.index');
 
Route::get('/programa', [ProgramaPublicController::class, 'index'])
    ->name('programa.index');

// ── Área pessoal via token único (enviado por email) ───────────
// Participante consulta estado e descarrega certificado sem login
Route::get('/i/{token}', [ParticipantInscricao::class, 'consultar'])
    ->name('inscricao.consultar')
    ->where('token', '[A-Za-z0-9]{48}');

Route::get('/i/{token}/certificado', [ParticipantInscricao::class, 'downloadCertificado'])
    ->name('inscricao.certificado')
    ->where('token', '[A-Za-z0-9]{48}');

// ═══════════════════════════════════════════════════════════════
//  AUTENTICAÇÃO — exclusiva para Admin / Organizador
// ═══════════════════════════════════════════════════════════════

Route::middleware('guest')->group(function () {
    Route::get('/painel/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/painel/login', [AdminAuthController::class, 'login']);
});

Route::post('/logout', [AdminAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ═══════════════════════════════════════════════════════════════
//  PAINEL ADMIN — auth + role obrigatórios
// ═══════════════════════════════════════════════════════════════
        // ── Download de comprovativo (admin) ─────────────────────
        Route::get('/comprovativo/{comprovativo}/download', [ComprovativoController::class, 'download'])
            ->name('comprovativo.download');
            
Route::middleware(['auth', 'role:admin,organizador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ── Inscrições ───────────────────────────────────────────
        Route::get('/inscricoes',                          [AdminInscricao::class, 'index'])->name('inscricoes.index');
        Route::get('/inscricoes/{inscricao}',              [AdminInscricao::class, 'show'])->name('inscricoes.show');
        Route::patch('/inscricoes/{inscricao}/dados',      [AdminInscricao::class, 'atualizarDados'])->name('inscricoes.atualizar-dados');
        Route::patch('/inscricoes/{inscricao}/aprovar',    [AdminInscricao::class, 'aprovar'])->name('inscricoes.aprovar');
        Route::patch('/inscricoes/{inscricao}/rejeitar',   [AdminInscricao::class, 'rejeitar'])->name('inscricoes.rejeitar');
        Route::patch('/inscricoes/{inscricao}/em-analise', [AdminInscricao::class, 'marcarEmAnalise'])->name('inscricoes.em-analise');
        Route::patch('/inscricoes/{inscricao}/checkin',    [AdminInscricao::class, 'checkin'])->name('inscricoes.checkin');

        // ── Exportação ───────────────────────────────────────────
        Route::get('/exportar/excel',    [ExportacaoController::class, 'excel'])->name('exportar.excel');
        Route::get('/exportar/csv',      [ExportacaoController::class, 'csv'])->name('exportar.csv');
        Route::get('/exportar/presenca', [ExportacaoController::class, 'presenca'])->name('exportar.presenca');

        // ── Certificados ─────────────────────────────────────────
        Route::get('/certificados',                        [CertificadoController::class, 'index'])->name('certificados.index');
        Route::post('/certificados/{inscricao}/gerar',     [CertificadoController::class, 'gerar'])->name('certificados.gerar');
        Route::post('/certificados/gerar-todos',           [CertificadoController::class, 'gerarTodos'])->name('certificados.gerar-todos');
        Route::get('/certificados/{certificado}/download', [CertificadoController::class, 'download'])->name('certificados.download');
        
        
        // ── Certificados — novas rotas adicionadas ────────────────────
        Route::get ('/certificados',                          [CertificadoController::class, 'index'])->name('certificados.index');
        Route::post('/certificados/{inscricao}/gerar',        [CertificadoController::class, 'gerar'])->name('certificados.gerar');
        Route::post('/certificados/gerar-todos',              [CertificadoController::class, 'gerarTodos'])->name('certificados.gerar-todos');
        Route::get ('/certificados/{certificado}/download',   [CertificadoController::class, 'download'])->name('certificados.download');
        // NOVAS:
        Route::post('/certificados/download-massa',           [CertificadoController::class, 'downloadMassa'])->name('certificados.download-massa');
        Route::get ('/certificados/download-todos',           [CertificadoController::class, 'downloadTodos'])->name('certificados.download-todos');
        
        
        Route::resource('galeria', AdminGaleriaController::class)
        ->except(['show'])
        ->names('galeria');
    
        Route::patch('galeria/{galeria}/toggle-ativo', [AdminGaleriaController::class, 'toggleAtivo'])
            ->name('galeria.toggle-ativo');
        
        Route::resource('programa', AdminProgramaController::class)
            ->except(['show'])
            ->parameters(['programa' => 'programa'])   // necessário: model ProgramaActividade, param 'programa'
            ->names('programa');
        
        Route::patch('programa/{programa}/toggle-ativo', [AdminProgramaController::class, 'toggleAtivo'])
            ->name('programa.toggle-ativo');


        // ── Apenas admin ─────────────────────────────────────────
        Route::middleware('role:admin')->group(function () {

            Route::resource('cursos', CursoController::class)->except(['show']);
            Route::patch('cursos/{curso}/toggle-ativo', [CursoController::class, 'toggleAtivo'])
                 ->name('cursos.toggle-ativo');

            Route::resource('speakers', AdminSpeakerController::class)->except(['show']);
            Route::patch('speakers/{speaker}/toggle-ativo',    [AdminSpeakerController::class, 'toggleAtivo'])->name('speakers.toggle-ativo');
            Route::patch('speakers/{speaker}/toggle-destaque', [AdminSpeakerController::class, 'toggleDestaque'])->name('speakers.toggle-destaque');

            Route::get('/utilizadores',  [UtilizadorController::class, 'index'])->name('utilizadores.index');
            Route::post('/utilizadores', [UtilizadorController::class, 'store'])->name('utilizadores.store');
        });
    });