<?php

namespace App\Http\Middleware;

use App;
use App\Entities\Message;
use App\Entities\Navbar;
use App\Entities\Auth;
use Inertia\Middleware;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';


    public function __construct(private Message $message, private Navbar $navbar, private Auth $auth)
    {
    }

    /**
     * Determine the current asset version.
     *
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }


    /**
     * Define the props that are shared by default.
     *
     * @param Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth'    => $this->auth->toArray(),
            'message' => $this->message->getMessage(),
            'navbar'  => $this->navbar->getNavbar(),
            'locale'  => App::getLocale(),
            'old'     => $request->input(),
        ]);
    }
}
