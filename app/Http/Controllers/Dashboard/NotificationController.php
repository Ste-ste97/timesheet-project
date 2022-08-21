<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response {
        return Inertia::render('Notification/Index', [
            'notifications' => auth()->user()->notifications()->paginate(10)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id): Response {
        $notification = auth()->user()->notifications()
                                      ->where('id', $id)
                                      ->firstOrFail();
        $notification->markAsRead();

        return Inertia::render('Notification/Show', [
            'notification' => $notification
        ]);
    }

    /**
     * Mark all notifications as read.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function markAllRead(Request $request): RedirectResponse {
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

    /**
     * Delete all user's notifications.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function massDestroy(Request $request): RedirectResponse {
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

    /**
     * Check whether the inbox is empty
     *
     * @param Request $request
     * @return bool
     */
    private function checkIfEmpty(Request $request): bool {
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
