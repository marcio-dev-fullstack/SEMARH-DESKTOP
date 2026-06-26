<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckTrialStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startDate = Carbon::parse(config('trial.start_date'));
        $trialEndDate = $startDate->copy()->addDays(60);
        $trialIsActive = now()->lessThanOrEqualTo($trialEndDate);

        // Se o trial estiver ativo, permite que a requisição continue.
        if ($trialIsActive) {
            return $next($request);
        }

        // Se o trial expirou, verifica se o usuário é um administrador.
        // Em um app real, Auth::user() conteria os dados do usuário logado.
        if (Auth::check() && Auth::user()->role === 'Administrador') {
            return $next($request); // Permite que o admin acesse para gerar o token.
        }

        // Redireciona todos os outros usuários para a tela de bloqueio.
        return redirect()->route('trial.locked');
    }
}