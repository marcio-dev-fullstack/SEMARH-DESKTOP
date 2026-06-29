<?php

namespace App\Actions\Processes;

use App\Models\ProcessoLicenciamento;
use Illuminate\Support\Facades\Auth;

class AddHistoryEntryAction
{
    public function execute(ProcessoLicenciamento $process, string $comment): void
    {
        $process->historico()->create([
            'user_id' => Auth::id(),
            'action' => 'comment',
            'new_values' => ['comment' => $comment],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}