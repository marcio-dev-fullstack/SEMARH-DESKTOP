<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Processos de Licenciamento</h5>
        <a href="{{ route('admin.processes.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Novo Processo
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar por protocolo ou requerente..." wire:model.live.debounce.300ms="search">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" wire:model.live="statusFilter">
                    <option value="">Todos os Status</option>
                    <option value="Protocolado">Protocolado</option>
                    <option value="Em Análise Técnica">Em Análise Técnica</option>
                    <option value="Aguardando Documentação">Aguardando Documentação</option>
                    <option value="Deferido">Deferido</option>
                    <option value="Indeferido">Indeferido</option>
                </select>
            </div>
            <div class="col-md-2 text-end">
                <button class="btn btn-outline-success" wire:click="exportCsv" wire:loading.attr="disabled">
                    <i class="bi bi-file-earmark-excel"></i> Exportar
                    <span wire:loading wire:target="exportCsv" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Protocolo</th>
                        <th scope="col">Requerente</th>
                        <th scope="col">Tipo de Licença</th>
                        <th scope="col">Status</th>
                        <th scope="col">Data da Solicitação</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($processes as $process)
                        @php
                            $statusClass = match($process->status) {
                                'Deferido' => 'bg-success',
                                'Indeferido' => 'bg-danger',
                                'Aguardando Documentação' => 'bg-warning text-dark',
                                'Em Análise Técnica' => 'bg-primary',
                                'Protocolado' => 'bg-secondary',
                                default => 'bg-light text-dark',
                            };
                        @endphp
                        <tr class="{{ $process->status === 'Aguardando Documentação' ? 'table-warning' : '' }}">
                            <td>{{ $process->protocolo }}</td>
                            <td>{{ $process->nome_requerente }}</td>
                            <td>{{ $process->tipo_licenca }}</td>
                            <td>
                                <span class="badge {{ $statusClass }}">{{ $process->status }}</span>
                            </td>
                            <td>{{ $process->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.processes.show', $process->id) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-secondary" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum processo encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $processes->links() }}
        </div>
    </div>
</div>