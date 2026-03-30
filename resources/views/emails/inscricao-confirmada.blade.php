<x-mail::message>

# Inscrição Recebida — CPSM 2026

Caro(a) **{{ $inscricao->full_name }}**,

A sua inscrição no **Iº Congresso de Psiquiatria e Saúde Mental em Angola** foi recebida com sucesso.

**Número de inscrição:** `{{ $inscricao->numero }}`

A comissão organizadora irá verificar o seu comprovativo de pagamento e receberá uma resposta por email em breve.

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

Em caso de dúvida, responda a este email ou contacte-nos através de **geral@cpsm2026.ao**.

Atenciosamente,  
**Comissão Organizadora do CPSM 2026**

</x-mail::message>