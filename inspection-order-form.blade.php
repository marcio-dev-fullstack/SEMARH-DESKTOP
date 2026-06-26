<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Gerar Ordem de Fiscalização</h4>
    </div>
    <form wire:submit.prevent="submit">
        <div class="card-body">
            <p>Você está criando uma ordem de fiscalização a partir da denúncia <strong>{{ $relatedProtocol }}</strong>.</p>
            <hr>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="agent" class="form-label">Atribuir ao Agente Fiscal</label>
                    <select class="form-select @error('selectedAgentId') is-invalid @enderror" id="agent" wire:model="selectedAgentId">
                        <option value="">Selecione um agente...</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent['id'] }}">{{ $agent['name'] }}</option>
                        @endforeach
                    </select>
                    @error('selectedAgentId') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="inspectionDate" class="form-label">Data Prevista para Fiscalização</label>
                    <input type="date" class="form-control @error('inspectionDate') is-invalid @enderror" id="inspectionDate" wire:model="inspectionDate">
                    @error('inspectionDate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label for="objectives" class="form-label">Objetivos / Escopo da Fiscalização</label>
                    <textarea class="form-control @error('objectives') is-invalid @enderror" id="objectives" rows="6" wire:model.lazy="objectives"></textarea>
                    @error('objectives') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <div class="alert alert-info">
                        <strong>Denúncia de Origem:</strong> {{ $relatedProtocol }} <br>
                        <strong>Localização:</strong> {{ $complaint['location'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.complaints.show', $complaint['id']) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="bi bi-shield-check"></i> Gerar e Atribuir Ordem
                </span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Gerando...
                </span>
            </button>
        </div>
    </form>
</div>