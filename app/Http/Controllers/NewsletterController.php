<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Guardar nova subscrição de newsletter.
     */
    public function store(Request $request)
    {
        // ── Validação ─────────────────────────────────────
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:320'],
        ], [
            'email.required' => 'O email é obrigatório.',
            'email.email'    => 'Introduza um email válido.',
            'email.max'      => 'O email não pode exceder 320 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('email'),
            ], 422);
        }

        $email = strtolower(trim($request->input('email')));

        try {
            // ── Verificar se já existe ────────────────────
            $exists = DB::table('newsletter_subscribers')
                ->where('email', $email)
                ->first();

            if ($exists) {
                // Se estava desativado, reativa
                if (! $exists->active) {
                    DB::table('newsletter_subscribers')
                        ->where('email', $email)
                        ->update([
                            'active'     => true,
                            'updated_at' => now(),
                        ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Subscrição reativada com sucesso!',
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Este email já está subscrito.',
                ], 409);
            }

            // ── Inserir nova subscrição ───────────────────
            DB::table('newsletter_subscribers')->insert([
                'email'      => $email,
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Nova subscrição de newsletter', ['email' => $email]);

            return response()->json([
                'success' => true,
                'message' => 'Subscrito com sucesso! Obrigado.',
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erro ao guardar subscrição de newsletter', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro. Tente novamente.',
            ], 500);
        }
    }

    /**
     * Cancelar subscrição (via link no email).
     */
    public function unsubscribe(Request $request)
    {
        $email = strtolower(trim($request->query('email', '')));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('home')
                ->with('error', 'Link de cancelamento inválido.');
        }

        DB::table('newsletter_subscribers')
            ->where('email', $email)
            ->update([
                'active'     => false,
                'updated_at' => now(),
            ]);

        return redirect()->route('home')
            ->with('success', 'Subscrição cancelada com sucesso.');
    }

    /**
     * Listar subscritores (apenas admin).
     */
    public function index()
    {
        $subscribers = DB::table('newsletter_subscribers')
            ->where('active', true)
            ->orderByDesc('created_at')
            ->paginate(50);

        return view('admin.newsletter.index', compact('subscribers'));
    }
}