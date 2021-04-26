<?php

namespace CreatyDev\Http\Account\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CreatyDev\Domain\Users\Models\User;
use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Ticket\Models\Ticket;
use CreatyDev\Domain\Account\Contestant;
use CreatyDev\Domain\Voter_logs;

class DashboardController extends Controller
{
    /**
     * Show the user's application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        // $contests = Auth::user()->contests->pluck('id')->toArray();
        // dd($contests);
        // $user = User::find(Auth::id());
        // $tickets = DB::table('tickets')->where()->get();
        $Nbtickets = Ticket::where('user_id', Auth::user()->id)->count();
        $contestants = Contestant::join('contest','contestants.contest_id','contest.id')->where('user_id', Auth::user()->id)->count('contestants.id');
        $no_of_votes = Contestant::join('contest','contestants.contest_id','contest.id')->where('user_id', Auth::user()->id)->sum('votes');
        $paid_votes = Voter_logs::join('contest','voter_log.contest_id','contest.id')->join('contestants','voter_log.contestent_id','contestants.id')->where('user_id', Auth::user()->id)->sum('no_of_votes');
        $amount = Voter_logs::join('contest','voter_log.contest_id','contest.id')->where('user_id', Auth::user()->id)->sum('amount');
        return view('account.dashboard.index', compact('Nbtickets','contestants','no_of_votes','amount','paid_votes'));
        // ->with('contestants',$contestants)->with('no_of_votes',$no_of_votes)->with('amount',$amount);
    }

    public function getDashboardSalesData()
    {
        $contestids = Auth::user()->contests->pluck('id')->toArray();
        $data = Voter_logs::selectRaw('currency , sum(amount) as totalamount , DATE_FORMAT(voter_log.created_at , "%b") as month , MONTH(voter_log.created_at) as monthno')
                            ->join('contest','contest.id','voter_log.contest_id')
                            ->whereIn('contest.id',$contestids)
                            ->groupBy('currency','month','monthno')
                            ->orderBy('monthno')
                            ->get();
        return $data;
    }
}
