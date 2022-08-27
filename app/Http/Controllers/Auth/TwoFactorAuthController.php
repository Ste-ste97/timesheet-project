<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TwoFactorRequest;
use App\Notifications\TwoFactorAuthNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class TwoFactorAuthController extends Controller
{
    /**
     * Display the 2FA view.
     *
     * @return Response|RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse {
        return (auth()->user()->hasPassed2FA() || !config('template.enable_2fa')) ? redirect()->intended(RouteServiceProvider::HOME) :
            Inertia::render('Auth/TwoFactorAuth');
    }

    /**
     * @param TwoFactorRequest $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function validateSession(TwoFactorRequest $request): RedirectResponse {
        $codeDB = DB::table('2fa_codes')
                  ->where('user_id', auth()->user()->id)
                  ->where('expires_at', '>', now())
                  ->first();

        if (empty($codeDB) || $codeDB->code !== $request->validated('secret')) {
            throw ValidationException::withMessages([
                'secret' => ['Your secret is invalid!'],
            ]);
        }

        DB::table('2fa_codes')
          ->where('user_id', auth()->user()->id)
          ->update(['expires_at' => now()]);

        Cache::add('2fa-'. $request->session()->getId(), true, 86400);
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Generate a new token
     */
    public function generateCode(): RedirectResponse {
        $code = Str::random(6);
        DB::table('2fa_codes')
          ->updateOrInsert(
              ['user_id' => auth()->user()->id],
              ['expires_at' => now()->addMinutes(10), 'code' => $code]
          );

        auth()->user()->notify(new TwoFactorAuthNotification($code));

        return redirect()->back();
    }
}
