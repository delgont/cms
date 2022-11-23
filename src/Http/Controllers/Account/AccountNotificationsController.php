<?php

namespace Delgont\Cms\Http\Controllers\Account;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Delgont\Cms\Models\Account\AccountNotifications as Notification;

class AccountNotificationsController extends Controller
{

    public function __construct()
    {
    }

    public function count()
    {
        $count = auth()->user()->unreadNotifications->count();
        return response()->json(['notificationsCount' => $count], 200);
    }

    public function index()
    {
        $notifications = auth()->user()->notifications;
        return (request()->expectsJson()) ? response()->json($notifications) : view('delgont::account.notifications.index', compact(['notifications']));
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update([
            'read_at' => now()
        ]);
        return (request()->expectsJson()) ? response()->json($notification) : view('delgont::account.notifications.show', compact(['notification']));
    }
    
    public function destroy($id)
    {
        Notification::destroy($id);
        return back();
    }
    
}
