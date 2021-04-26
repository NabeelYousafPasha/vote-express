<?php

namespace CreatyDev\Http\Admin\Controllers;

use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Account\Contest;

use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\Ticket\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Storage;

class ContestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Contest::paginate(10);
        //dd($data[2]->Contestants);
        $table = [
            'fields' => [
                'title' => 'Event Title',
                'desc' => 'Description',
                'contest_type' => 'Contest Type',
                'contest_currency' => 'Currency',
                'start_date' =>'start_date',
                'end_date' => 'end_date',
            ],
            'action' => [
                'route_name_edit' => 'admin.contest.edit',
                'route_name_delete' => '',
                'route_name_show' => 'admin.contest.show',
                'key_name' => 'id', // 'id' by default
            ]
        ];
        $title = 'Contest';
        $titles = 'Contests';
        return view('admin.contests.index', compact('data','title','titles','table'));
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
        return view('admin.contests.create',compact('title','titles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'contest_currency' => ['required',Rule::in(['NGN', 'USD'])],
            'contest_logo' => ['required','image','mimes:png,jpg,jpeg'],
            'desc' => 'required|string',
            'contest_type' => 'required',
            'vote_amount' => 'required|integer',
            'vote_count' => ['required',Rule::in(['number', 'percentage'])],
            'votetopercent' => 'requiredIf:vote_count,percentage|nullable|integer',
            'start_date' => 'required|date|before:end_date',
            'end_date' => ['required','date','after:start_date'],
        ]);
// dd();
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
        $titles = 'Contest';
        $contest = Contest::where('id', $id)->firstOrFail();

        return view('admin.contests.create', compact('contest','title','titles'));
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'contest_currency' => ['required',Rule::in(['NGN', 'USD'])],
            'contest_logo' => ['filled','image','mimes:png,jpg,jpeg'],
            'desc' => 'required|string',
            'contest_type' => 'required',
            'vote_amount' => 'required|integer',
            'vote_count' => ['required',Rule::in(['number', 'percentage'])],
            'votetopercent' => 'requiredIf:vote_count,percentage|nullable|integer',
            'start_date' => 'required|date|before:end_date',
            'end_date' => ['required','date','after:start_date'],
        ]);
        
        $contest = Contest::findOrFail($id);
        if(!empty($request->contest_logo)){
            $contest_logo = storage::disk('public')->putFile('/contestlogos',$request->contest_logo,'');
            $contest->contest_logo = $contest_logo;
        }

        $contest->title = $request->input('title');
        $contest->desc = $request->input('desc');
        $contest->contest_type = $request->input('contest_type');
        $contest->start_date =$request->input('start_date') ?? $contest->start_date;
        $contest->end_date =$request->input('end_date') ?? $contest->end_date;
        // $contest->user_id  = Auth::user()->id;
        $contest->contest_currency = $request->input('contest_currency');
        $contest->vote_amount = $request->input('vote_amount');
        $contest->vote_count = $request->input('vote_count');
        $contest->votetopercent = $request->input('votetopercent');

        $contest->save();

        return redirect('admin/contests')->with("status", "contest has been updated.");
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
        return view('admin.contests.contestbuilder',compact('title','titles','contest_id', 'form_data'));
    }

    public function updateForm(Request $request)
    {
        $contest = Contest::find($request->contest);
        $contest->form_data = json_encode($request->form_data);
        $contest->save();
        return $contest;
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
        return view('admin.contests.renderform', compact('form_data','contest','title','titles'));
    }

    public function publish($id)
    {
        $contest=Contest::findOrFail($id);
        $contestants=$contest->contestants;
        
        //dd($contestants[0]->form_data);
        return view('admin.contests.publish3', compact('contest'));
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
