<?php

namespace App\Http\Middleware;

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


    public function __construct(Message $message, Navbar $navbar, Auth $auth) {
        $this->message = $message;
        $this->navbar  = $navbar;
        $this->auth    = $auth;
    }

    /**
     * Determine the current asset version.
     *
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request): ?string {
        return parent::version($request);
    }


    /**
     * Define the props that are shared by default.
     *
     * @param Request $request
     * @return array
     */
    public function share(Request $request): array {
        return array_merge(parent::share($request), [
            'auth'    => $this->auth->toArray(),
            'message' => $this->message->getMessage(),
            'navbar'  => $this->navbar->getNavbar()
        ]);
    }
}
