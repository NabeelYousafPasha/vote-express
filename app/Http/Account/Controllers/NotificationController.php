<?php

namespace CreatyDev\Http\Account\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Messages\Message;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Message::where('receiver',auth()->user()->id)->get();

        return view('account.notification.index', compact('notifications'));
    }

    public function notification(){
        $notifications = Message::where('receiver',auth()->user()->id)->get();

        return $notifications;
    }

    public function notificationread(){
        /* auth()->user()->unreadNotifications->markAsRead(); */
        $notifications = Message::where('receiver',auth()->user()->id)->get();
        foreach ($notifications as $key => $notify) {
            $notify->status ='read';
            $notify->save;
        }
        return ['message' => 'All notifications as mark as read.'];
    }

    public function notificationdelete(Request $request){
        // auth()->user()->notifications($request->id)->delete();
        $notifications = Message::findOrFail($request->id);
        $notifications->delete();
        return redirect()->back()->with("status", "Notifications is delete successfully.");
    }

    public function notificationsingleread(Request $request)
    {
        // auth()->user()->unreadNotifications($request->id)->update(['read_at' => now()]);
        $notifications = Message::findOrFail($request->id);
        $notifications->status='read';
        $notifications->save();
        return redirect()->back()->with("status", "notifications as mark as read.");
    }
}
