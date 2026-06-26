<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Usuários do Sistema</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Novo Usuário
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar por nome ou e-mail..." wire:model.live.debounce.300ms="search">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['role'] }}</td>
                            <td>
                                <span class="badge {{ $user['status'] === 'Ativo' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user['status'] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user['id']) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="{{ route('admin.users.permissions', $user['id']) }}" class="btn btn-sm btn-outline-info" title="Ver Permissões">
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>