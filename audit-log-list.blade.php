<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Log de Auditoria do Sistema</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar por usuário, ação, registro..." wire:model.live.debounce.300ms="search">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Data/Hora</th>
                        <th scope="col">Usuário</th>
                        <th scope="col">Ação</th>
                        <th scope="col">Registro Afetado</th>
                        <th scope="col">IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($log['created_at'])->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $log['user'] }}</td>
                            <td><span class="badge bg-info text-dark">{{ $log['action'] }}</span></td>
                            <td>{{ $log['auditable'] }}</td>
                            <td>{{ $log['ip_address'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum registro de auditoria encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $logs->links() }}
        </div>
    </div>
</div>