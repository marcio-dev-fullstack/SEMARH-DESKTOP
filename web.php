<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas web para sua aplicação.
|
*/

Route::get('/', fn () => view('welcome'))->name('home');

// Rota para a página de login da intranet
Route::get('/login', fn () => view('pages.auth.login'))->name('login');

// Rota para a funcionalidade de "Sair" (Logout)
Route::post('/logout', function (Request $request) {
    // Em uma aplicação real, Auth::logout() seria chamado aqui.
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Rota para a página "Esqueci minha senha"
Route::get('/forgot-password', fn () => view('pages.auth.forgot-password'))->name('password.request');

// Rota para a página de redefinição de senha
Route::get('/reset-password/{token}', fn ($token) => view('pages.auth.reset-password', ['token' => $token]))->name('password.reset');

// Rota para a tela de sistema bloqueado
Route::get('/locked', fn() => view('pages.auth.locked'))->name('trial.locked');

// Rota para a página de solicitação de licença
Route::get('/solicitar-licenca', fn () => view('pages.citizen.license-application'))->name('citizen.license.application');

// Rota para a página de consulta de processo
Route::get('/consultar-processo', fn () => view('pages.citizen.process-search'))->name('citizen.process.search');

// Rota para a página de registro de denúncia
Route::get('/registrar-denuncia', fn () => view('pages.citizen.complaint-registration'))->name('citizen.complaint.create');

// Rota para a página de emissão de taxas
Route::get('/emissao-taxas', fn () => view('pages.citizen.fees'))->name('citizen.fees');

// Rota para a página do chatbot
Route::get('/chatbot-ambiental', fn () => view('pages.citizen.chatbot'))->name('citizen.chatbot');

// --- Rotas do Painel Administrativo ---
Route::prefix('admin')->name('admin.')->group(function () {
    // Rota para o dashboard
    Route::get('/dashboard', fn () => view('pages.admin.dashboard'))->name('dashboard');
    // Rota para a listagem de processos
    Route::get('/processes', fn () => view('pages.admin.processes.index'))->name('processes.index');
    // Rota para a criação de processo
    Route::get('/processes/create', fn () => view('pages.admin.processes.create'))->name('processes.create');
    // Rota para os detalhes de um processo
    Route::get('/processes/{process}', fn ($process) => view('pages.admin.processes.show', ['processId' => $process]))->name('processes.show');
    // Rota para a listagem de denúncias
    Route::get('/complaints', fn () => view('pages.admin.complaints.index'))->name('complaints.index');
    // Rota para os detalhes de uma denúncia
    Route::get('/complaints/{complaint}', fn ($complaint) => view('pages.admin.complaints.show', ['complaintId' => $complaint]))->name('complaints.show');
    // Rota para criar uma ordem de fiscalização a partir de uma denúncia
    Route::get('/inspections/create-from-complaint/{complaint}', fn ($complaint) => view('pages.admin.inspections.create', ['complaintId' => $complaint]))->name('inspections.create.from-complaint');
    // Rota para a versão de impressão/PDF da lista de denúncias
    Route::get('/complaints-print', [\App\Livewire\Admin\ComplaintList::class, 'exportPdf'])->name('complaints.print');
    // Rota para a listagem de fiscalizações
    Route::get('/inspections', fn () => view('pages.admin.inspections.index'))->name('inspections.index');
    // Rota para os detalhes de uma fiscalização
    Route::get('/inspections/{inspection}', fn ($inspection) => view('pages.admin.inspections.show', ['inspectionId' => $inspection]))->name('inspections.show');
    // Rota para a versão de impressão/PDF do relatório de fiscalização
    Route::get('/inspections/{inspection}/print', function ($inspectionId) {
        // Esta lógica seria idealmente movida para um Controller, mas para manter a simplicidade,
        // vamos replicar a busca de dados aqui.
        $allInspections = collect([
            ['id' => 1, 'protocol' => 'FSC-2026-001', 'origin' => 'Denúncia DEN-2026-002', 'agent' => 'Agente Fiscal 001', 'status' => 'Realizada', 'date' => '2026-06-25', 'report' => 'Visita realizada no local. Constatado despejo de resíduos sólidos no córrego. Foram coletadas amostras e fotos. O responsável não foi encontrado no momento da visita.', 'evidence' => [['type' => 'image', 'path' => 'https://via.placeholder.com/600x400.png?text=Evidência+1'], ['type' => 'image', 'path' => 'https://via.placeholder.com/600x400.png?text=Evidência+2']]],
            ['id' => 2, 'protocol' => 'FSC-2026-002', 'origin' => 'Processo 202601-12345', 'agent' => 'Agente Fiscal 002', 'status' => 'Agendada', 'date' => '2026-06-28', 'report' => 'Fiscalização agendada para verificar o cumprimento das condicionantes da licença.', 'evidence' => []],
            ['id' => 3, 'protocol' => 'FSC-2026-003', 'origin' => 'Ofício', 'agent' => 'Agente Fiscal 001', 'status' => 'Em Campo', 'date' => '2026-06-26', 'report' => 'Agente em deslocamento para o local da fiscalização.', 'evidence' => []],
            ['id' => 4, 'protocol' => 'FSC-2026-004', 'origin' => 'Denúncia DEN-2026-003', 'agent' => 'Agente Fiscal 003', 'status' => 'Concluída com Auto', 'date' => '2026-06-20', 'report' => 'Desmatamento ilegal confirmado. Foi lavrado o Auto de Infração nº 123/2026.', 'evidence' => [['type' => 'image', 'path' => 'https://via.placeholder.com/600x400.png?text=Evidência+3']]],
            ['id' => 5, 'protocol' => 'FSC-2026-005', 'origin' => 'Rotina', 'agent' => 'Agente Fiscal 002', 'status' => 'Concluída sem Auto', 'date' => '2026-06-18', 'report' => 'Visita de rotina realizada. Nenhuma irregularidade encontrada.', 'evidence' => []],
        ]);
        $inspection = $allInspections->firstWhere('id', (int) $inspectionId);
        return view('pages.admin.inspections.print', compact('inspection'));
    })->name('inspections.print');

    // Grupo de rotas de gerenciamento de usuários, protegido por middleware
    // Route::middleware(['can:manage-users'])->group(function () {
        Route::get('/users', fn () => view('pages.admin.users.index'))->name('users.index');
        Route::get('/users/create', fn () => view('pages.admin.users.create'))->name('users.create');
        Route::get('/users/{user}/edit', fn ($user) => view('pages.admin.users.edit', ['userId' => $user]))->name('users.edit');
        Route::get('/users/{user}/permissions', fn ($user) => view('pages.admin.users.permissions', ['userId' => $user]))->name('users.permissions');
    // });

    // Rota para a página de perfil do usuário logado
    Route::get('/profile', fn () => view('pages.admin.profile.show'))->name('profile.show');

    // Rota para a página de configurações do sistema
    Route::get('/settings', fn () => view('pages.admin.settings.index'))->name('settings.index');

    // Rota para a página de log de auditoria
    Route::get('/audit-logs', fn () => view('pages.admin.audit.index'))->name('audit.index');
});

// --- Rotas da Interface Mobile ---
Route::prefix('mobile')->name('mobile.')->group(function () {
    // Rota para o dashboard do agente
    Route::get('/dashboard', fn () => view('pages.mobile.dashboard'))->name('dashboard');
    // Rota para a lista de tarefas do agente
    Route::get('/tasks', fn () => view('pages.mobile.tasks'))->name('tasks');
});