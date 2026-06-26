<x-layouts.citizen>
    @section('title', 'Bem-vindo ao Portal do Cidadão')

    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Portal do Cidadão - SEMARH Fiscaliza</h1>
            <p class="col-md-8 fs-4">Seu canal direto para solicitar licenças, consultar processos e registrar denúncias ambientais de forma 100% digital.</p>
            <a href="#" class="btn btn-primary btn-lg">Acessar com GOV.BR</a>
        </div>
    </div>

    <div class="row align-items-md-stretch">
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 text-bg-dark rounded-3">
                <h2>Solicitar Licença Ambiental</h2>
                <p>Inicie seu processo de licenciamento (LP, LI, LO) de forma rápida e segura. Acompanhe todas as etapas online.</p>
                <a href="{{ route('citizen.license.application') }}" class="btn btn-outline-light">Iniciar Solicitação</a>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="h-100 p-5 bg-light border rounded-3">
                <h2>Registrar Denúncia</h2>
                <p>Ajude a proteger o meio ambiente. Registre uma denúncia anônima ou identificada com geolocalização e fotos.</p>
                <a href="{{ route('citizen.complaint.create') }}" class="btn btn-outline-secondary">Fazer Denúncia</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h2>Serviços Disponíveis</h2>
            <div class="list-group">
                <a href="{{ route('citizen.process.search') }}" class="list-group-item list-group-item-action">Consulta Processual</a>
                <a href="{{ route('citizen.fees') }}" class="list-group-item list-group-item-action">Emissão de Taxas e Boletos</a>
                <a href="#" class="list-group-item list-group-item-action">Acompanhamento de Condicionantes</a>
                <a href="{{ route('citizen.chatbot') }}" class="list-group-item list-group-item-action">Fale com nosso Chatbot Ambiental</a>
            </div>
        </div>
    </div>

</x-layouts.citizen>