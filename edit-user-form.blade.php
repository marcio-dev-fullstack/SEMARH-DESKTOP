<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Editar Usuário: {{ $name }}</h4>
    </div>
    <form wire:submit.prevent="submit">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <label for="name" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.lazy="name">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail de Acesso</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model.lazy="email">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="role" class="form-label">Perfil de Acesso</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" wire:model.live="role">
                        <option value="Administrador">Administrador</option>
                        <option value="Analista">Analista</option>
                        <option value="Agente Fiscal">Agente Fiscal</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" wire:model="status">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                @if ($role === 'Analista' || $role === 'Agente Fiscal')
                    <div class="col-md-6">
                        <label for="cpf" class="form-label">CPF (*)</label>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" wire:model.lazy="cpf" placeholder="000.000.000-00">
                        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="celular" class="form-label">Celular (*)</label>
                        <input type="text" class="form-control @error('celular') is-invalid @enderror" id="celular" wire:model.lazy="celular" placeholder="(00) 00000-0000">
                        @error('celular') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="matricula" class="form-label">Matrícula Funcional (*)</label>
                        <input type="text" class="form-control @error('matricula') is-invalid @enderror" id="matricula" wire:model.lazy="matricula">
                        @error('matricula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                @endif

            </div>

            <hr class="my-4">

            <h5 class="mb-3">Ações de Segurança</h5>
            @if (session()->has('password_reset_message'))
                <div class="alert alert-success">
                    {{ session('password_reset_message') }}
                </div>
            @endif
            <div class="p-3 border rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Redefinir Senha</strong>
                        <p class="mb-0 text-muted">Um e-mail será enviado ao usuário com um link para criar uma nova senha.</p>
                    </div>
                    <button type="button" class="btn btn-outline-danger" wire:click="sendPasswordReset" wire:loading.attr="disabled">
                        Enviar Link de Redefinição
                    </button>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="bi bi-save"></i> Salvar Alterações
                </span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Salvando...
                </span>
            </button>
        </div>
    </form>
</div>