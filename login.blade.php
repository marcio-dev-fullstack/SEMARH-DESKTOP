<x-layouts.auth>
    @php
        $startDate = \Carbon\Carbon::parse(config('trial.start_date'));
        $endDate = $startDate->copy()->addDays(60);
        $daysRemaining = now()->diffInDays($endDate, false);
        $trialIsActive = $daysRemaining >= 0;
    @endphp

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">

            <div class="text-center text-white mb-4">
                {{-- Aqui você pode colocar a imagem da sua logo --}}
                <h1 class="display-4 fw-bold">SEMARH DIGITAL</h1>
                <p class="lead">Secretaria Municipal de Meio Ambiente e Recursos Hídricos</p>
            </div>

            <div class="login-box">
                {{-- Este componente Livewire irá conter a lógica do formulário --}}
                @livewire('auth.login-form')
            </div>

            @if($trialIsActive)
                <div class="text-center text-white mt-3 p-2 bg-dark bg-opacity-50 rounded">
                    <small>Período de avaliação: <strong>{{ $daysRemaining }}</strong> dias restantes.</small>
                </div>
            @endif

        </div>
    </div>
</x-layouts.auth>

{{-- Componente Livewire para o formulário de login --}}
@livewire_component('auth.login-form')
    <form wire:submit.prevent="authenticate">
        @if ($errors->any())
            <div class="alert alert-danger mb-3 py-2">
                @foreach ($errors->all() as $error)
                    <small>{{ $error }}</small>
                @endforeach
            </div>
        @endif

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" wire:model.lazy="email" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" wire:model.lazy="password" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" wire:model="remember">
            <label class="form-check-label" for="remember">Lembrar-me</o>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">Entrar</button>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="text-decoration-none text-success">Esqueci minha senha</a>
        </div>
    </form>
@endlivewire_component