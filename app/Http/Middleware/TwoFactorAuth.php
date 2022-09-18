<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TwoFactorAuth
{
    public function handle(Request $request, Closure $next): mixed {
        if (!config('template.enable_2fa')) {
            return $next($request);
        }

        if ($request->user() && !$request->user()->hasPassed2FA() && !str_starts_with($request->route()->getName(), '2FA')) {
            return redirect()->route('2FA.verify');
        }

        if ($request->route()->getName() === 'logout') {
            Cache::forget('2fa-'. $request->session()->getId());
        }

        return $next($request);
    }
}