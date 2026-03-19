{{-- resources/views/participant/sucesso.blade.php --}}
@extends('layouts.app')

@section('title', 'Inscrição Recebida — CPSA 2025')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">

    {{-- Ícone de sucesso --}}
    <div class="mb-6 flex justify-center">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>

    <div class="text-center mb-10">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Inscrição recebida!</h1>
        <p class="text-gray-600">
            Obrigado pela sua inscrição no CPSA 2025. A comissão irá analisar o seu pedido e
            receberá uma resposta por email em breve.
        </p>
    </div>

    {{-- Número da inscrição --}}
    @if(session('inscricao_numero'))
    <div class="mb-6 rounded-xl border border-gray-200 bg-gray-50 px-6 py-4 text-center">
        <p class="text-xs font-medium uppercase tracking-widest text-gray-400 mb-1">Número de inscrição</p>
        <p class="text-xl font-mono font-semibold text-gray-900">{{ session('inscricao_numero') }}</p>
        @if(session('inscricao_email'))
        <p class="mt-1 text-sm text-gray-500">Confirmação enviada para <strong>{{ session('inscricao_email') }}</strong></p>
        @endif
    </div>
    @endif

    {{-- Link único de acesso --}}
    @if(session('inscricao_token'))
    <div class="rounded-xl border-2 border-blue-200 bg-blue-50 p-6 mb-6">
        <div class="flex items-start gap-3 mb-4">
            <div class="mt-0.5 flex-shrink-0">
                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-blue-900 text-sm mb-1">O seu link de acesso pessoal</p>
                <p class="text-xs text-blue-700">
                    Use este link para consultar o estado da sua inscrição e descarregar o certificado — sem precisar de criar conta.
                    Guarde-o num local seguro.
                </p>
            </div>
        </div>

        {{-- URL visível --}}
        <div class="flex items-center gap-2 rounded-lg border border-blue-300 bg-white px-3 py-2.5">
            <span id="access-url" class="flex-1 truncate font-mono text-xs text-gray-700 select-all">
                {{ route('inscricao.consultar', session('inscricao_token')) }}
            </span>
            <button
                id="copy-btn"
                type="button"
                onclick="copiarLink()"
                class="flex-shrink-0 rounded-md bg-blue-700 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-800 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Copiar
            </button>
        </div>

        <p id="copy-feedback" class="mt-2 text-xs text-green-700 hidden">
            ✓ Link copiado!
        </p>

        {{-- Ir para a área pessoal --}}
        <div class="mt-4">
            <a
                href="{{ route('inscricao.consultar', session('inscricao_token')) }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-700 hover:text-blue-900 underline underline-offset-2"
            >
                Abrir a minha área pessoal
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
    @endif

    {{-- Próximos passos --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 mb-8">
        <h2 class="text-sm font-semibold text-gray-900 mb-3">O que acontece a seguir?</h2>
        <ol class="space-y-3">
            <li class="flex gap-3 text-sm text-gray-600">
                <span class="flex-shrink-0 flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">1</span>
                A comissão irá analisar o seu comprovativo de pagamento.
            </li>
            <li class="flex gap-3 text-sm text-gray-600">
                <span class="flex-shrink-0 flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">2</span>
                Receberá um email de confirmação de aprovação ou pedido de esclarecimento.
            </li>
            <li class="flex gap-3 text-sm text-gray-600">
                <span class="flex-shrink-0 flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700">3</span>
                Após o congresso, o certificado de participação estará disponível no seu link pessoal.
            </li>
        </ol>
    </div>

    <div class="text-center">
        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700 underline underline-offset-2">
            Voltar à página inicial
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
function copiarLink() {
    const url = document.getElementById('access-url').textContent.trim();
    const feedback = document.getElementById('copy-feedback');
    const btn = document.getElementById('copy-btn');

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(() => mostrarFeedback());
    } else {
        // Fallback para browsers mais antigos
        const ta = document.createElement('textarea');
        ta.value = url;
        ta.style.cssText = 'position:fixed;opacity:0;pointer-events:none';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); mostrarFeedback(); } catch {}
        document.body.removeChild(ta);
    }

    function mostrarFeedback() {
        btn.textContent = 'Copiado!';
        btn.classList.replace('bg-blue-700', 'bg-green-600');
        feedback.classList.remove('hidden');
        setTimeout(() => {
            btn.textContent = 'Copiar';
            btn.classList.replace('bg-green-600', 'bg-blue-700');
            feedback.classList.add('hidden');
        }, 3000);
    }
}
</script>
@endpush