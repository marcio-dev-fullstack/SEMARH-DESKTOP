<x-layouts.auth>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">

            <div class="text-center text-white mb-4">
                <h1 class="display-6 fw-bold">Cadastrar Nova Senha</h1>
                <p class="lead">Secretaria Municipal de Meio Ambiente e Recursos Hídricos</p>
            </div>

            <div class="login-box">
                @livewire('auth.reset-password-form', ['token' => $token])
            </div>

        </div>
    </div>
</x-layouts.auth>

@livewire_component('auth.reset-password-form')
    <form wire:submit.prevent="resetPassword">
        <input type="hidden" wire:model="token">

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model.lazy="email" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" wire:model.lazy="password" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
            <input type="password" class="form-control" id="password_confirmation" wire:model.lazy="password_confirmation" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">Redefinir Senha</button>
        </div>
    </form>
@endlivewire_component