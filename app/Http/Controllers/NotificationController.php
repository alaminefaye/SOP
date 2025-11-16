<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications.
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        $unreadCount = Auth::user()->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back()
            ->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Show notification and redirect to procedure.
     */
    public function show($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            if (isset($notification->data['procedure_id'])) {
                return redirect()->route('procedures.show', $notification->data['procedure_id']);
            }
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()
            ->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Delete notification.
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->delete();
        }

        return redirect()->back()
            ->with('success', 'Notification supprimée.');
    }
}
