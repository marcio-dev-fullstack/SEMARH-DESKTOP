<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Convidar Novo Usuário</h4>
    </div>
    <form wire:submit.prevent="submit">
        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-info-circle-fill"></i>
                O usuário receberá um convite por e-mail para definir sua senha e ativar a conta.
            </div>
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
                    <label for="role" class="form-label">Perfil de Acesso (*)</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" wire:model.live="role">
                        <option value="">Selecione um perfil...</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Analista">Analista</option>
                        <option value="Agente Fiscal">Agente Fiscal</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="bi bi-send-fill"></i> Enviar Convite
                </span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Enviando...
                </span>
            </button>
        </div>
    </form>
</div>