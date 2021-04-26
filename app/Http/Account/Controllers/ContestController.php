<?php

namespace CreatyDev\Http\Account\Controllers;

use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Account\Contest;
use CreatyDev\Domain\Ticket\Mail\SendTicket;
use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\Ticket\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Storage;

use CreatyDev\App\Support\SecureRandomString;

class ContestController extends Controller
{
    public function __construct(){
        $this->middleware('subscription.active');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Contest::where('user_id',auth()->user()->id)->paginate(10);
        $table = [
            'fields' => [
                'title' => 'Event Title',
                'desc' => 'Description',
                'contest_type' => 'Contest Type',
                'contest_currency' => 'Currency',
                'start_date' =>'Start Date',
                'end_date' => 'End Date',
            ],
            'action' => [
                'route_name_edit' => 'account.contest.edit',
                'route_name_delete' => '',
                'route_name_show' => 'account.contest.show',
                'key_name' => 'id', // 'id' by default
            ]
        ];
        $title = 'Contest';
        $titles = 'Contests';
        return view('account.contests.index', compact('data','title','titles','table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Contest';
        $titles = 'Contests';
        $plan = auth()->user()->subscriptions()->first();

        // if($plan->stripe_plan == 'Basic' && !is_null($plan->ends_at)){
        //     $sub_end_date = new Carbon($plan->ends_at);
        // }elseif (in_array($plan->stripe_plan, ['Gold','Premium']) && !is_null($plan->ends_at)) {
        //     # code...
        // }
        if(!is_null(auth()->user()->subscriptions[0]->ends_at)){
            $sub_start_date = auth()->user()->subscriptions[0]->ends_at;
            $carbon_sub_date = new Carbon($sub_start_date);
            
        }elseif($plan->stripe_plan != 'Basic'){
            $sub_start_date = auth()->user()->subscriptions[0]->created_at;
            $carbon_sub_date = new Carbon($sub_start_date);

            $sub_duration = auth()->user()->plan->duration;
            $duration = explode(',',$sub_duration);

            if($duration[1] == "day"){
                $carbon_sub_date->addDays($duration[0]);
            }elseif($duration[1] == "week"){
                $carbon_sub_date->addWeeks($duration[0]);
            }elseif($duration[1] == "month"){
                $carbon_sub_date->addMonth($duration[0]);
            }elseif($duration[1] == "year"){
                $carbon_sub_date->addYear($duration[0]);
            }
        }else{
            $carbon_sub_date = null;
        }
        
        

        return view('account.contests.create',compact('title','titles','carbon_sub_date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plan = auth()->user()->subscriptions()->first();
        if(!is_null(auth()->user()->subscriptions[0]->ends_at)){
            $sub_start_date = auth()->user()->subscriptions[0]->ends_at;
            $carbon_sub_date = new Carbon($sub_start_date);
            
        }elseif($plan->stripe_plan != 'Basic'){
            $sub_start_date = auth()->user()->subscriptions[0]->created_at;
            $carbon_sub_date = new Carbon($sub_start_date);

            $sub_duration = auth()->user()->plan->duration;
            $duration = explode(',',$sub_duration);

            if($duration[1] == "day"){
                $carbon_sub_date->addDays($duration[0]);
            }elseif($duration[1] == "week"){
                $carbon_sub_date->addWeeks($duration[0]);
            }elseif($duration[1] == "month"){
                $carbon_sub_date->addMonth($duration[0]);
            }elseif($duration[1] == "year"){
                $carbon_sub_date->addYear($duration[0]);
            }
        }else{
            $carbon_sub_date = null;
        }

        $this->validate($request, [
            'title' => 'required|string|max:191',
            /* 'street_address' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'zip_code' => 'required|string|max:191',
            'country' => 'required|string|max:191', */
            'contest_currency' => ['required',Rule::in(['NGN', 'USD'])],
            'contest_logo' => ['required','image','mimes:png,jpg,jpeg'],
            'desc' => 'required|string',
            'contest_type' => 'required',
            'vote_amount' => 'required',
            'vote_count' => ['required',Rule::in(['number', 'percentage'])],
            'votetopercent' => 'requiredIf:vote_count,percentage|nullable|integer',
            'start_date' => 'required|date|before:end_date',
            'end_date' => ['required','date','after:start_date'],
            // ,'before:'.$carbon_sub_date
        ]);
        $createcontest = false;
        if ($request->end_date > $carbon_sub_date) {
            $secdiff = $carbon_sub_date->diffInSeconds(Carbon::parse($request->end_date));
            $daydiff = ceil(($secdiff/3600)/24);
            $weeks = ceil($daydiff/7);
            // chargeamount multiply by 100 to convert into pennies
            $chargeamount = $weeks * 10 * 100;
            // dd($daydiff , $weeks , $chargeamount);
            $charge = $request->user()->invoiceFor($weeks.'week(s)',$chargeamount);
            if(!$charge->status == "succeeded"){
                return redirect()->back()->with("status", "Payment failed.");
            }else{
                $date = $request->user()->subscriptions()->first()->update([
                    'ends_at' => $carbon_sub_date->addWeeks($weeks),
                ]);
                // dd($date);
                $createcontest = true;
            }
        }else{
            $createcontest = true;
        }
        // dd($request);

        if($createcontest){
            $contest = new Contest;
            $contest->fill($request->all());
            $contest->user_id=auth()->user()->id;
            $random_string=$this->random_text();
            $duplicate=Contest::where('slug',$random_string)->get();
            if(count($duplicate) <= 0)
            {
                $contest->slug=$random_string;
            }
            $contest_logo = storage::disk('public')->putFile('/contestlogos',$request->contest_logo,'');
            $contest->contest_logo = $contest_logo;
            $contest->save();
            return redirect()->back()->with("status", "Contest has been created.");
        }else{
            return redirect()->back()->with("status", "Something went wrong.");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        return view('tickets.show', compact('ticket'));
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Contest';
        $titles = 'Contests';
        $contest = Contest::where('id', $id)->firstOrFail();

        return view('account.contests.create', compact('contest','title','titles'));
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'desc' => 'required|string',
            'contest_type' => 'required',
        ]);
        
        $contest = Contest::findOrFail($id);

        $contest->title = $request->input('title');
        $contest->desc = $request->input('desc');
        $contest->contest_type = $request->input('contest_type');
        $contest->start_date =$request->input('start_date') ?? $contest->start_date;
        $contest->end_date =$request->input('end_date') ?? $contest->end_date;
        $contest->user_id  = Auth::user()->id;

        $contest->save();

        // $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect('account/contests')->with("status", "contest has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CreatyDev\Domain\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return 'delete';
        $contest=Contest::findOrFail($id);
        if($contest){
            $contest->delete();
        }
        return redirect()->back()->with("status", "contest deleted.");
    }

    public function createForm(Request $request)
    {
        $form_data = null;
        $title = 'Contest Form';
        $titles = 'Contests';

        $contest_id = $request->contest;
        $contest = Contest::find($request->contest);
        if($contest->form_data)
           { $form_data = json_decode($contest->form_data,false); }
        return view('account.contests.contestbuilder',compact('title','titles','contest_id', 'form_data'));
    }

    public function updateForm(Request $request)
    {
        $contest = Contest::find($request->contest);
        $contest->form_data = json_encode($request->form_data);
        $contest->save();
        return $contest;
        // return view('account.events.create', compact('data','title','titles'));
    }

    public function getForm(Request $request)
    {
        //dd($request->contest_id);
        $form_data = null;
        $title = 'Contest Form';
        $titles = 'Contests';

        $contest = Contest::find($request->contest_id);
        if($contest->form_data)
           { $form_data = json_decode($contest->form_data,false); }
        //return $form_data;
        return view('account.contests.renderform', compact('form_data','contest','title','titles'));
    }

    public function contestBuilder()
    {
        $title = 'Contest';
        $titles = 'Contests';
        return view('account.contests.contestbuilder',compact('title','titles'));
    }

    public function publish($id)
    {
        $contest=Contest::findOrFail($id);
        $contestants=$contest->contestants;
        
        //dd($contestants[0]->form_data);
        return view('account.contests.publish3', compact('contest'));
    }

    public function random_text( $type = 'alnum', $length = 8 )
	{
		switch ( $type ) {
			case 'alnum':
				$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 'alpha':
				$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 'hexdec':
				$pool = '0123456789abcdef';
				break;
			case 'numeric':
				$pool = '0123456789';
				break;
			case 'nozero':
				$pool = '123456789';
				break;
			case 'distinct':
				$pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
				break;
			default:
				$pool = (string) $type;
				break;
		}


		$crypto_rand_secure = function ( $min, $max ) {
			$range = $max - $min;
			if ( $range < 0 ) return $min; // not so random...
			$log    = log( $range, 2 );
			$bytes  = (int) ( $log / 8 ) + 1; // length in bytes
			$bits   = (int) $log + 1; // length in bits
			$filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
			do {
				$rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
				$rnd = $rnd & $filter; // discard irrelevant bits
			} while ( $rnd >= $range );
			return $min + $rnd;
		};

		$token = "";
		$max   = strlen( $pool );
		for ( $i = 0; $i < $length; $i++ ) {
			$token .= $pool[$crypto_rand_secure( 0, $max )];
		}
		return $token;
	}
}
