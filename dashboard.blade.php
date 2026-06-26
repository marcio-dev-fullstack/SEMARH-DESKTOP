<x-layouts.admin>
    @section('title', 'Dashboard')

    <div class="row">
        <!-- Card Exemplo 1 -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-primary py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Processos em Análise</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>42</span></div>
                        </div>
                        <div class="col-auto"><i class="bi-folder2-open fs-2 text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Exemplo 2 -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Licenças Emitidas (Mês)</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>15</span></div>
                        </div>
                        <div class="col-auto"><i class="bi-patch-check-fill fs-2 text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Exemplo 3 -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-warning py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Denúncias Pendentes</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>8</span></div>
                        </div>
                        <div class="col-auto"><i class="bi-exclamation-triangle-fill fs-2 text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-4">
        Bem-vindo ao Painel Administrativo do SEMARH Fiscaliza. Aqui você pode gerenciar todos os processos e operações do sistema.
    </div>

</x-layouts.admin>