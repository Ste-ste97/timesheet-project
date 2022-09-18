<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SimpleNotification;

class TestController extends Controller
{
    /**
     * Your test logic goes here.
     */
    public function __invoke()
    {
        $user = User::first();
        $user->notify(new SimpleNotification('Test', 'Testing body'));

        echo 'OK';
    }
}
