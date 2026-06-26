<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Ordens de Fiscalização</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="statusFilter" class="form-label">Filtrar por Status</label>
                <select class="form-select" id="statusFilter" wire:model.live="statusFilter">
                    <option value="">Todos os Status</option>
                    <option value="Agendada">Agendada</option>
                    <option value="Em Campo">Em Campo</option>
                    <option value="Realizada">Realizada</option>
                    <option value="Concluída com Auto">Concluída com Auto</option>
                    <option value="Concluída sem Auto">Concluída sem Auto</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Protocolo</th>
                        <th scope="col">Origem</th>
                        <th scope="col">Agente Fiscal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inspections as $inspection)
                        <tr>
                            <td>{{ $inspection['protocol'] }}</td>
                            <td>{{ $inspection['origin'] }}</td>
                            <td>{{ $inspection['agent'] }}</td>
                            <td><span class="badge bg-info text-dark">{{ $inspection['status'] }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($inspection['date'])->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.inspections.show', $inspection['id']) }}" class="btn btn-sm btn-outline-primary" title="Ver Relatório">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhuma fiscalização encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $inspections->links() }}
        </div>
    </div>
</div>