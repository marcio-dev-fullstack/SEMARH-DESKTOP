<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Gestão de Denúncias</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="statusFilter" class="form-label">Filtrar por Status</label>
                <select class="form-select" id="statusFilter" wire:model.live="statusFilter">
                    <option value="">Todos os Status</option>
                    <option value="Recebida">Recebida</option>
                    <option value="Em Verificação">Em Verificação</option>
                    <option value="Aguardando Laudo">Aguardando Laudo</option>
                    <option value="Concluída">Concluída</option>
                    <option value="Arquivada">Arquivada</option>
                </select>
            </div>
            <div class="col-md-8 text-end">
                <a href="{{ route('admin.complaints.print', ['statusFilter' => $statusFilter]) }}" target="_blank" class="btn btn-outline-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Protocolo</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data</th>
                        <th scope="col">Localização (Resumo)</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint['protocol'] }}</td>
                            <td>
                                @if ($complaint['is_anonymous'])
                                    <span class="badge bg-secondary">Anônima</span>
                                @else
                                    <span class="badge bg-light text-dark">Identificada</span>
                                @endif
                            </td>
                            <td><span class="badge bg-warning text-dark">{{ $complaint['status'] }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($complaint['date'])->format('d/m/Y') }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($complaint['location'], 40) }}</td>
                            <td>
                                <a href="{{ route('admin.complaints.show', $complaint['id']) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-success" title="Gerar Fiscalização">
                                    <i class="bi bi-shield-check"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhuma denúncia encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $complaints->links() }}
        </div>
    </div>
</div>