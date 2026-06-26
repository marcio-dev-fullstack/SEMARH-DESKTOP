<div>
    @if ($process)
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Processo: {{ $process->protocolo }}</h4>
                    <small>Requerente: {{ $process->nome_requerente }}</small>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary fs-6">{{ $process->status }}</span>
                    <div class="mt-1">Analista: {{ $process->analista->name ?? 'Não atribuído' }}</div>
                </div>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs" id="processTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($activeTab === 'general') active @endif" wire:click="setTab('general')" type="button">
                            <i class="bi bi-info-circle-fill"></i> Informações Gerais
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($activeTab === 'documents') active @endif" wire:click="setTab('documents')" type="button">
                            <i class="bi bi-folder-fill"></i> Documentos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($activeTab === 'history') active @endif" wire:click="setTab('history')" type="button">
                            <i class="bi bi-clock-history"></i> Histórico
                        </button>
                    </li>
                </ul>

                <div class="tab-content pt-3">
                    {{-- Aba de Informações Gerais --}}
                    <div class="tab-pane fade @if($activeTab === 'general') show active @endif">
                        <h5>Detalhes da Solicitação</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Protocolo:</strong> {{ $process->protocolo }}</li>
                            <li class="list-group-item"><strong>Tipo de Licença:</strong> {{ $process->tipo_licenca }}</li>
                            <li class="list-group-item"><strong>Data da Solicitação:</strong> {{ $process->created_at->format('d/m/Y') }}</li>
                        </ul>

                        <h5 class="mt-4">Dados do Requerente</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nome/Razão Social:</strong> {{ $process->nome_requerente }}</li>
                            <li class="list-group-item"><strong>CPF/CNPJ:</strong> {{ $process->documento_requerente }}</li>
                        </ul>

                        <h5 class="mt-4">Descrição do Empreendimento</h5>
                        <p>{{ $process->descricao_atividade }}</p>
                    </div>

                    {{-- Aba de Documentos --}}
                    <div class="tab-pane fade @if($activeTab === 'documents') show active @endif">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Anexar Novo Documento</h5>
                                @if ($documentMessage)
                                    <div class="alert alert-success">{{ $documentMessage }}</div>
                                @endif
                                <form wire:submit.prevent="uploadDocument">
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('newDocument') is-invalid @enderror" wire:model="newDocument">
                                        <button class="btn btn-secondary" type="submit" wire:loading.attr="disabled" wire:target="newDocument">
                                            <span wire:loading.remove wire:target="newDocument"><i class="bi bi-upload"></i> Enviar</span>
                                            <span wire:loading wire:target="newDocument">Enviando...</span>
                                        </button>
                                        @error('newDocument') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                    </div>
                                    <div wire:loading wire:target="newDocument" class="form-text text-primary">
                                        Aguarde, o arquivo está sendo processado...
                                    </div>
                                </form>
                            </div>
                        </div>

                        <h5 class="mt-4">Documentos do Processo</h5>
                        <div class="list-group">
                            @forelse ($process->documentos as $doc)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-1">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <a href="{{ asset('storage/' . $doc->path) }}" target="_blank">{{ $doc->name }}</a>
                                            </h6>
                                            <small class="text-muted">Enviado por: {{ $doc->user->name ?? 'Sistema' }}</small>
                                        </div>
                                        <small>{{ $doc->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item text-center">
                                    Nenhum documento anexado a este processo.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Aba de Histórico --}}
                    <div class="tab-pane fade @if($activeTab === 'history') show active @endif">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Adicionar Novo Registro ao Histórico</h5>
                                @if ($historyMessage)
                                    <div class="alert alert-success">{{ $historyMessage }}</div>
                                @endif
                                <form wire:submit.prevent="addHistoryEntry">
                                    <div class="mb-3">
                                        <label for="newHistoryEntry" class="form-label">Descrição do Evento</label>
                                        <textarea class="form-control @error('newHistoryEntry') is-invalid @enderror" id="newHistoryEntry" rows="3" wire:model.lazy="newHistoryEntry" placeholder="Ex: Recebimento de documentação complementar."></textarea>
                                        @error('newHistoryEntry') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <button type="submit" class="btn btn-secondary">
                                        <span wire:loading.remove wire:target="addHistoryEntry"><i class="bi bi-plus-circle"></i> Adicionar</span>
                                        <span wire:loading wire:target="addHistoryEntry">Adicionando...</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <h5 class="mt-4">Timeline do Processo</h5>
                        <ul class="list-group mt-3">
                            @forelse ($process->historico as $entry)
                                <li class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><strong>Usuário:</strong> {{ $entry->user->name ?? 'Sistema' }}</h6>
                                        <small>{{ $entry->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1">{{ $entry->new_values['comment'] ?? "Ação: {$entry->action}" }}</p>
                                </li>
                            @empty
                                <li class="list-group-item">Nenhum registro de histórico encontrado.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Processo não encontrado.
        </div>
    @endif
</div>