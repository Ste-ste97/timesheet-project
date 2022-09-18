<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Notification/Index', [
            'notifications' => auth()->user()->notifications()->paginate(10)
        ]);
    }

    public function show($id): Response
    {
        $notification = auth()->user()->notifications()
                              ->where('id', $id)
                              ->firstOrFail();
        $notification->markAsRead();

        return Inertia::render('Notification/Show', [
            'notification' => $notification
        ]);
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        if ($this->checkIfEmpty($request)) {
            return redirect()->back();
        }

        auth()->user()->notifications->markAsRead();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Marked everything as read.')
        ]);

        return redirect()->back();
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        if ($this->checkIfEmpty($request)) {
            return redirect()->back();
        }

        auth()->user()->notifications()->delete();

        $request->session()->flash('message', [
            'type'    => 'success', // error, success, info
            'message' => __('Inbox has been cleared.')
        ]);

        return redirect()->back();
    }

    private function checkIfEmpty(Request $request): bool
    {
        if (!auth()->user()->notifications()->exists()) {
            $request->session()->flash('message', [
                'type'    => 'info', // error, success, info
                'message' => __('Your inbox is empty.')
            ]);

            return true;
        }
        return false;
    }

}
