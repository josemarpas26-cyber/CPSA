{{-- resources/views/emails/inscricao-confirmada.blade.php --}}
<x-mail::message>

# Inscrição Recebida — CPSA 2025

Caro(a) **{{ $inscricao->full_name }}**,

A sua inscrição no **Congresso de Psiquiatria e Saúde Mental em Angola 2025** foi recebida com sucesso.

**Número de inscrição:** `{{ $inscricao->numero }}`

A comissão organizadora irá verificar o seu comprovativo de pagamento e receberá uma resposta por email em breve.

---

## O seu link de acesso pessoal

Use o link abaixo para consultar o estado da sua inscrição e, após o congresso, descarregar o seu certificado de participação — **sem precisar de criar conta**.

<x-mail::button :url="route('inscricao.consultar', $inscricao->access_token)" color="primary">
Consultar a minha inscrição
</x-mail::button>

> **Guarde este email.** O link é único e pessoal. Qualquer pessoa com este link pode ver os seus dados de inscrição.

---

### Resumo da inscrição

| Campo | Valor |
|---|---|
| Nome | {{ $inscricao->full_name }} |
| Email | {{ $inscricao->email }} |
| Categoria | {{ $inscricao->category_label }} |
| Participação | {{ $inscricao->participation_mode_label }} |
| Curso inscrito | {{ $inscricao->inscricaoCurso?->curso?->nome ?? '—' }} |

---

Em caso de dúvida, responda a este email ou contacte-nos através de **geral@cpsa2025.ao**.

Atenciosamente,  
**Comissão Organizadora do CPSA 2025**

</x-mail::message>