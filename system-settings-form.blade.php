<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Configurações Gerais do Sistema</h4>
    </div>
    <form wire:submit.prevent="saveSettings">
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="mb-4 p-3 border rounded">
                <label for="system_name" class="form-label">Nome do Sistema</label>
                <input type="text" class="form-control @error('system_name') is-invalid @enderror" id="system_name" wire:model.lazy="system_name">
                @error('system_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Este nome aparecerá no título das páginas e em outras áreas do sistema.</div>
            </div>

            <div class="mb-4 p-3 border rounded bg-light">
                <h5 class="mb-3">Modo de Manutenção</h5>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="maintenance_mode" wire:model="maintenance_mode">
                    <label class="form-check-label" for="maintenance_mode">Ativar modo de manutenção</label>
                </div>
                <div class="form-text">Ao ativar, apenas administradores poderão acessar o sistema. Uma página de manutenção será exibida para os demais usuários.</div>
            </div>

            <div class="mb-4 p-3 border rounded">
                <h5 class="mb-3">Status do Trial</h5>
                @if ($days_remaining > 0)
                    <p>O período de avaliação termina em: <strong>{{ $trial_end_date->format('d/m/Y') }}</strong> ({{ $days_remaining }} dias restantes).</p>
                @else
                    <p class="text-danger">O período de avaliação expirou.</p>
                @endif

                @if (session()->has('token_message'))
                    <div class="alert alert-success">
                        {{ session('token_message') }}
                    </div>
                @endif

                @if($generated_token)
                    <div class="alert alert-warning">
                        <strong>Token de Ativação:</strong>
                        <p class="fs-5" style="word-wrap: break-word;">{{ $generated_token }}</p>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Gerar Token de Ativação</strong>
                        <p class="mb-0 text-muted">Gera um token temporário para reativar o sistema.</p>
                    </div>
                    <button type="button" class="btn btn-outline-success" wire:click="generateActivationToken">
                        Gerar Token
                    </button>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="bi bi-save"></i> Salvar Configurações
                </span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Salvando...
                </span>
            </button>
        </div>
    </form>
</div>