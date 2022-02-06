<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    private function getMessage(Request $request)
    {
        $msg = $request->session()->get('message');
        if (! $msg)
            return null;

        return array_merge($msg, ['fingerprint' => Str::uuid()]);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'message' => $this->getMessage($request),
        ]);
    }
}
