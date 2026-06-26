<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Fiscalização - {{ $inspection['protocol'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
            .page-break {
                page-break-after: always;
            }
        }
        body {
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container mt-4">
        <div class="text-center mb-4">
            <img src="https://via.placeholder.com/150x50.png?text=SEMARH+Fiscaliza" alt="Logo" class="mb-2">
            <h2>Relatório de Fiscalização</h2>
        </div>

        <p class="no-print text-center">Este relatório está sendo preparado para impressão. Se a janela de impressão não abrir automaticamente, pressione Ctrl+P (ou Cmd+P).</p>

        <div class="card">
            <div class="card-header">
                <strong>Protocolo: {{ $inspection['protocol'] }}</strong>
            </div>
            <div class="card-body">
                <p><strong>Data da Fiscalização:</strong> {{ \Carbon\Carbon::parse($inspection['date'])->format('d/m/Y') }}</p>
                <p><strong>Agente Responsável:</strong> {{ $inspection['agent'] }}</p>
                <p><strong>Origem da Demanda:</strong> {{ $inspection['origin'] }}</p>
                <p><strong>Status Atual:</strong> {{ $inspection['status'] }}</p>
            </div>
        </div>

        <h4 class="mt-4">Relatório Descritivo</h4>
        <div class="p-3 border rounded">
            <p>{{ $inspection['report'] }}</p>
        </div>

        @if (!empty($inspection['evidence']))
            <div class="page-break"></div>
            <h3 class="mt-4">Evidências Coletadas</h3>
            <div class="row g-3">
                @foreach ($inspection['evidence'] as $item)
                    @if ($item['type'] === 'image')
                        <div class="col-6 mb-3">
                            <div class="card">
                                <img src="{{ $item['path'] }}" class="card-img-top" alt="Evidência">
                                <div class="card-footer text-muted">
                                    Evidência fotográfica
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>