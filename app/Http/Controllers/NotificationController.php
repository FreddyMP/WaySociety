<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->appNotifications()->latest()->paginate(20);
        Auth::user()->appNotifications()->whereNull('read_at')->update(['read_at' => now()]);
        return view('notifications.index', compact('notifications'));
    }

    public function markRead(AppNotification $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->update(['read_at' => now()]);
        }
        return response()->json(['success' => true]);
    }

    public function unreadCount()
    {
        $count = Auth::user()->appNotifications()->unread()->count();
        return response()->json(['count' => $count]);
    }
}
