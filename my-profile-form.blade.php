<div>
    <div class="row">
        <div class="col-lg-8">
            <!-- Formulário de Dados do Perfil -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações do Perfil</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('profile_message'))
                        <div class="alert alert-success">
                            {{ session('profile_message') }}
                        </div>
                    @endif
                    <form wire:submit.prevent="updateProfile">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model.lazy="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model.lazy="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" class="form-control @error('celular') is-invalid @enderror" id="celular" wire:model.lazy="celular">
                            @error('celular') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- Formulário de Alteração de Senha -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Alterar Senha</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('password_message'))
                        <div class="alert alert-success">
                            {{ session('password_message') }}
                        </div>
                    @endif
                    <form wire:submit.prevent="changePassword">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Senha Atual</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" wire:model.lazy="current_password">
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" wire:model.lazy="new_password">
                            @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="new_password_confirmation" wire:model.lazy="new_password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-danger">Alterar Senha</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>