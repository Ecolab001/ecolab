<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
public function handle($request, Closure $next)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user()->fresh();

    if ($user->role === 'representative') {

        // 🔴 CAS 1 : pas d'expiration définie = bloquer
        if (!$user->expires_at) {
            $user->update(['status' => 'expired']);
            return redirect()->route('subscription.required');
        }

        // 🔴 CAS 2 : expiration dépassée
        if (now()->greaterThan($user->expires_at)) {
            $user->update(['status' => 'expired']);
            return redirect()->route('subscription.required');
        }

        // 🔴 CAS 3 : statut incohérent
        if ($user->status !== 'active') {
            return redirect()->route('subscription.required');
        }
    }

    return $next($request);
}
}