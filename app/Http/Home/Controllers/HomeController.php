<?php

namespace CreatyDev\Http\Home\Controllers;

use Illuminate\Http\Request;
use CreatyDev\App\Controllers\Controller;
use Sarfraznawaz2005\VisitLog\Facades\VisitLog;
use CreatyDev\Domain\Subscriptions\Models\Plan;
use CreatyDev\Domain\Account\Contest;
use Carbon\Carbon;
use Session;
use Crypt;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Log the visitor
        VisitLog::save();
        // Get Plans to show on the landing page
        $plans =  Plan::take('4')->get();
        return view('home.index', compact('plans'));
    }

    public function explore()
    {
        $contest = Contest::with('owner')->where('status',1)->where('start_date','<=',Carbon::today())->where('end_date','>=',Carbon::today())->get();
        // dd($contest);
        return view('home.explore', compact('contest'));
    }

    public function publish($id)
    {
        $contest=Contest::findOrFail($id);
        $contestants=$contest->contestants;
        return view('publish3', compact('contest'));
    }

    public function iframePublish($id)
    {
        $id = Crypt::decrypt($id);
        $contest=Contest::findOrFail($id);
        $contestants=$contest->contestants;
        return view('iframepublish', compact('contest'));
    }
}
