<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Permissões de: {{ $user['name'] }}</h4>
        <small>Perfil: {{ $user['role'] }}</small>
    </div>
    <form wire:submit.prevent="submit">
        <div class="card-body">
            @if ($user['role'] === 'Administrador')
                <div class="alert alert-success">
                    <i class="bi bi-shield-check-fill"></i>
                    Administradores têm acesso total a todas as funcionalidades do sistema.
                </div>
            @else
                <div class="alert alert-info">
                    Selecione as permissões que este usuário terá acesso.
                </div>
            @endif

            <div class="row">
                @foreach ($allPermissions as $module => $permissions)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header">{{ $module }}</div>
                            <div class="card-body">
                                @foreach ($permissions as $permission => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $permission }}" id="{{ $permission }}" wire:model="userPermissions" @if($user['role'] === 'Administrador') disabled @endif>
                                        <label class="form-check-label" for="{{ $permission }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Voltar</a>
            @if ($user['role'] !== 'Administrador')
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <i class="bi bi-save"></i> Salvar Permissões
                </button>
            @endif
        </div>
    </form>
</div>