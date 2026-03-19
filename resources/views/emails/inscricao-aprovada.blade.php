{{-- resources/views/emails/inscricao-aprovada.blade.php --}}
<x-mail::message>

# Inscrição Aprovada — CPSA 2025 ✓

Caro(a) **{{ $inscricao->full_name }}**,

Temos o prazer de informar que a sua inscrição no **Congresso de Psiquiatria e Saúde Mental em Angola 2025** foi **aprovada**.

**Número de inscrição:** `{{ $inscricao->numero }}`

---

## Aceder à sua área pessoal

Através do link abaixo pode consultar todos os detalhes da sua inscrição e, após o congresso, descarregar o seu certificado de participação.

<x-mail::button :url="route('inscricao.consultar', $inscricao->access_token)" color="success">
Ver a minha inscrição
</x-mail::button>

---

### Detalhes de participação

| Campo | Valor |
|---|---|
| Nome | {{ $inscricao->full_name }} |
| Modo | {{ $inscricao->participation_mode_label }} |
| Curso / Workshop | {{ $inscricao->inscricaoCurso?->curso?->nome ?? '—' }} |

@if($inscricao->participation_mode === 'presencial')
<x-mail::panel>
**Participação Presencial** — Por favor, apresente-se com documento de identificação no dia do evento para efectuar o check-in.
</x-mail::panel>
@else
<x-mail::panel>
**Participação Online** — Receberá as instruções de acesso à plataforma alguns dias antes do evento.
</x-mail::panel>
@endif

---

### Certificado de participação

Após a conclusão do congresso, o seu certificado ficará disponível para download no seu link pessoal. Receberá também um email de aviso quando estiver pronto.

> Este link é único e pessoal. Guarde-o num local seguro.

---

Atenciosamente,  
**Comissão Organizadora do CPSA 2025**  
geral@cpsa2025.ao

</x-mail::message>