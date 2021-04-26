<?php

namespace CreatyDev\Http\Admin\Controllers\Annoucement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Messages\Message;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Foundation\Console\Presets\Vue;

use CreatyDev\Domain\Notifications\Annoucement;

class AnnoucementController extends Controller
{
        
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        
        
    }

    public function create(){
        $users = User::whereHas("role", function($q){ $q->where("slug", "admin"); })->get();
        
        return View('admin.annoucement.create',compact('users'));
    }

    public function store(Request $request){
        /* $message = $request->all();
        $users = User::all();
        Notification::send($users, new Annoucement($message)); */
        $this->validate($request, [
            'receiver' => 'required|integer',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);
        //dd($request->all());
        $message = new Message;

        $message->receiver=$request->receiver;
        $message->sender=auth()->user()->id;
        $message->subject=$request->subject;
        $message->message=$request->body;

        $message->save();
        return redirect()->back()->with("status", "Your notification sent successfully.");

    }


}
