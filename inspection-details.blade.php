<div>
    @if ($inspection)
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Relatório de Fiscalização: {{ $inspection['protocol'] }}</h4>
                    <small>Agente: {{ $inspection['agent'] }} | Data: {{ \Carbon\Carbon::parse($inspection['date'])->format('d/m/Y') }}</small>
                </div>
                <span class="badge bg-primary fs-6">{{ $inspection['status'] }}</span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h5>Resumo da Fiscalização</h5>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item">
                                <strong>Protocolo:</strong> {{ $inspection['protocol'] }}
                            </li>
                            <li class="list-group-item">
                                <strong>Origem:</strong> {{ $inspection['origin'] }}
                            </li>
                        </ul>

                        <h5 class="mt-4">Relatório Descritivo do Agente</h5>
                        <div class="p-3 border rounded bg-light">
                            <p>{{ $inspection['report'] }}</p>
                        </div>

                        <h5 class="mt-4">Evidências Coletadas</h5>
                        @if (!empty($inspection['evidence']))
                            <div class="row g-3">
                                @foreach ($inspection['evidence'] as $item)
                                    @if ($item['type'] === 'image')
                                        <div class="col-md-4">
                                            <a href="{{ $item['path'] }}" target="_blank">
                                                <img src="{{ $item['path'] }}" class="img-fluid rounded img-thumbnail" alt="Evidência">
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-secondary">
                                Nenhuma evidência foi anexada a esta fiscalização.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('admin.inspections.index') }}" class="btn btn-secondary">Voltar para a Lista</a>
                <a href="{{ route('admin.inspections.print', $inspection['id']) }}" target="_blank" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Gerar PDF
                </a>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Fiscalização não encontrada.
        </div>
    @endif
</div>