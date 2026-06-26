<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Formulário de Denúncia Ambiental</h4>
            </div>
            <div class="card-body">
                <p>Sua contribuição é fundamental para a proteção do meio ambiente. As informações serão tratadas com sigilo.</p>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição Detalhada da Ocorrência</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="5" wire:model.lazy="description" placeholder="Descreva o que está acontecendo, quem são os possíveis infratores, quando ocorre, etc."></textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Localização da Ocorrência</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" wire:model.lazy="location" placeholder="Forneça o endereço, ponto de referência ou coordenadas geográficas.">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Anexar Foto (Opcional)</label>
                    <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" wire:model="photo">
                     @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div wire:loading wire:target="photo" class="text-primary mt-1">Carregando...</div>
                    @if ($photo)
                        <div class="mt-2">Pré-visualização:
                            <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif
                </div>

                <hr>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_anonymous" wire:model.live="is_anonymous">
                    <label class="form-check-label" for="is_anonymous">Desejo fazer uma denúncia anônima.</label>
                </div>

                @if (!$is_anonymous)
                    <div class="row g-3 p-3 border rounded bg-light">
                        <p class="mb-2">Ao se identificar, você poderá receber atualizações sobre o andamento da sua denúncia por e-mail.</p>
                        <div class="col-md-6">
                            <label for="reporter_name" class="form-label">Seu Nome Completo</label>
                            <input type="text" class="form-control @error('reporter_name') is-invalid @enderror" id="reporter_name" wire:model.lazy="reporter_name">
                            @error('reporter_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="reporter_email" class="form-label">Seu E-mail</label>
                            <input type="email" class="form-control @error('reporter_email') is-invalid @enderror" id="reporter_email" wire:model.lazy="reporter_email">
                            @error('reporter_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                @endif

            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-danger btn-lg" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="bi bi-send-fill"></i> Enviar Denúncia
                    </span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Enviando...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>