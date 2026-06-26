<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Formulário de Solicitação de Licença Ambiental</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">1. Dados do Requerente</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="requesterName" class="form-label">Nome Completo / Razão Social</label>
                        <input type="text" class="form-control @error('requesterName') is-invalid @enderror" id="requesterName" wire:model.lazy="requesterName">
                        @error('requesterName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="requesterDocument" class="form-label">CPF / CNPJ</label>
                        <input type="text" class="form-control @error('requesterDocument') is-invalid @enderror" id="requesterDocument" wire:model.lazy="requesterDocument">
                        @error('requesterDocument') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="requesterEmail" class="form-label">E-mail para Contato</label>
                        <input type="email" class="form-control @error('requesterEmail') is-invalid @enderror" id="requesterEmail" wire:model.lazy="requesterEmail">
                        @error('requesterEmail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="requesterPhone" class="form-label">Telefone / Celular</label>
                        <input type="text" class="form-control @error('requesterPhone') is-invalid @enderror" id="requesterPhone" wire:model.lazy="requesterPhone">
                        @error('requesterPhone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr>

                <h5 class="card-title mt-4">2. Dados do Empreendimento e da Solicitação</h5>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="licenseType" class="form-label">Tipo de Licença Requerida</label>
                        <select class="form-select @error('licenseType') is-invalid @enderror" id="licenseType" wire:model="licenseType">
                            <option value="">Selecione...</option>
                            <option value="LP">Licença Prévia (LP)</option>
                            <option value="LI">Licença de Instalação (LI)</option>
                            <option value="LO">Licença de Operação (LO)</option>
                            <option value="Simplificada">Licença Simplificada</option>
                        </select>
                        @error('licenseType') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="activityDescription" class="form-label">Descrição Detalhada do Empreendimento ou Atividade</label>
                        <textarea class="form-control @error('activityDescription') is-invalid @enderror" id="activityDescription" rows="4" wire:model.lazy="activityDescription"></textarea>
                        @error('activityDescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr>

                <div class="form-check mt-4">
                    <input class="form-check-input @error('termsAccepted') is-invalid @enderror" type="checkbox" id="termsAccepted" wire:model="termsAccepted">
                    <label class="form-check-label" for="termsAccepted">
                        Declaro, sob as penas da lei, que as informações prestadas neste formulário são verdadeiras e assumo total responsabilidade por elas.
                    </label>
                    @error('termsAccepted') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary btn-lg" wire:loading.attr="disabled">
                    <span wire:loading.remove>Protocolar Solicitação</span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Enviando...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>