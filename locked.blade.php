<x-layouts.auth>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="text-center text-white mb-4">
                <h1 class="display-6 fw-bold">Sistema Bloqueado</h1>
                <p class="lead">O período de avaliação terminou.</p>
            </div>

            <div class="login-box">
                @livewire('auth.token-validator-form')
            </div>

        </div>
    </div>
</x-layouts.auth>

@livewire_component('auth.token-validator-form')
    <form wire:submit.prevent="validateToken">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <hr>
                <p class="mb-0">ENTRE EM CONTATO COM O SUPORTE TÉCNICO<br><strong>(62) 99646-6033</strong><br><small>SOMENTE MENSAGENS</small></p>
            </div>
        @endif

        <p class="text-muted">Por favor, insira um token de ativação válido para reativar o sistema.</p>

        <div class="mb-3">
            <label for="token" class="form-label">Token de Ativação</label>
            <input type="text" class="form-control @error('token') is-invalid @enderror" id="token" wire:model.lazy="token" required autofocus>
            @error('token') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">Validar e Reativar</button>
        </div>
    </form>
@endlivewire_component