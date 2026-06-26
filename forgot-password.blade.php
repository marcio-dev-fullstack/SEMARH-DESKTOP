<x-layouts.auth>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">

            <div class="text-center text-white mb-4">
                <h1 class="display-6 fw-bold">Redefinir Senha</h1>
                <p class="lead">Secretaria Municipal de Meio Ambiente e Recursos Hídricos</p>
            </div>

            <div class="login-box">
                @livewire('auth.forgot-password-form')
            </div>

        </div>
    </div>
</x-layouts.auth>

@livewire_component('auth.forgot-password-form')
    <form wire:submit.prevent="sendResetLink">
        @if ($emailSentMessage)
            <div class="alert alert-success">
                {{ $emailSentMessage }}
            </div>
        @endif

        <p class="text-muted">Digite seu e-mail e enviaremos um link para você voltar a acessar sua conta.</p>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model.lazy="email" required autofocus>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">Enviar Link</button>
        </div>
    </form>
@endlivewire_component