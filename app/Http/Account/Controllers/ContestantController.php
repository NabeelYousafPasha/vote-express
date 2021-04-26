<?php

namespace CreatyDev\Http\Account\Controllers;

use CreatyDev\App\Controllers\Controller;

use CreatyDev\Domain\Account\Contest;
use CreatyDev\Domain\Account\Contestant;
use CreatyDev\Domain\Ticket\Mail\SendTicket;
use CreatyDev\Domain\Ticket\Models\Category;
use CreatyDev\Domain\Ticket\Models\Ticket;
use Storage;

use Excel;
use CreatyDev\Imports\ContestantsImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContestantController extends Controller
{
    public function __construct(){
        $this->middleware('subscription.active');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Contestants';
        $titles = 'Contestants';
        
        $table = [
            'fields' => [
                'Name' => 'Event Name',
                'Email' => 'Email',
                'Phone' => 'Phone',
                'Avatar' =>'Avatar',
                'Contest' => 'Contest',
                'votes'=>'votes',
            ],
            'action' => [
                'route_name_edit' => 'account.contestant.edit',
                'route_name_delete' => '',
                'route_name_show' => 'account.contestant.show',
                'key_name' => 'id', // 'id' by default
            ]
        ];
        if ($request->contest_id) {
            $dataa = Contestant::where('contest_id',$request->contest_id)->paginate(10);
            
            return view('account.contestants.show', compact('dataa','title','titles','table'));
        }
        $contest = Contest::where('user_id',auth()->user()->id)->paginate(10);
        
        
        return view('account.contestants.index', compact('contest','title','titles','table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = 'Contestants';
        $titles = 'Contestants';
        $contest=Contest::where('id',$request->contest_id)->first();
        
        if ($contest) {
           return view('account.contestants.create',compact('title','titles','contest'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'contestants_file' =>'required|mimes:xlsx,xls',
            'contest_id'=>'required'
        ]);

        $path=$request->file('contestants_file')->getRealPath();
        $data=Excel::import(new ContestantsImport($request->contest_id),$path);
        

        return back()->with('success','Data imported successfully');
    }

    public function storeFormData(Request $request)
    {
        $contest_id = Contest::where('id', $request->contest)->pluck('id')->first();
        
        $contestant =  new Contestant;
        $contestant->contest_id = $contest_id;
        $contestant->form_data = json_encode($request->form_data);
        $contestant->save();
    }

    public function uploadAvatar(Request $request)
    {
        // dd($request);
        $contestent = Contestant::find($request->contestant_id);
        if($contestent){
            $avatar = storage::disk('public')->putFile('/uploads/contestants',$request->avatar,'');
            $contestent->avatar = $avatar;
            if($contestent->save()){
                return back()->with('success','Avatar Updated Successfully');
            }else{
                return redirect()->back()->with("status", "New Avatar is not uploaded.");
            }
        }else{
            return redirect()->back()->with("status", "Invalid Contestant data");
        }
    }

    public function addVotes(Request $request)
    {
        $contestent = Contestant::find($request->contestant_id);
        if($contestent){
            $contestent->votes = $contestent->votes + $request->added_votes;
            if($contestent->save()){
                return back()->with('success','Votes Added Successfully');
            }else{
                return redirect()->back()->with("status", "Votes not Added.");
            }
        }else{
            return redirect()->back()->with("status", "Invalid Contestant data");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \CreatyDev\Domain\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function show(Contestant $contestant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $title = 'Contestants';
        $titles = 'Contestants';
        $contestant = Contestant::where('id', $id)->first();
        
        if ($request->q=='form_data') 
        {
            $form_data=json_decode($contestant->contestt->form_data,false);
            $contestant_data=$contestant->form_data;

            return view('account.contestants.edit',compact('title','titles','contestant','form_data','contestant_data'));
        }
        else {
            return view('account.contestants.edit',compact('title','titles','contestant'));
        }
        //dd($contestant->form_data);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CreatyDev\Domain\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        /* $this->validate($request, [
            'vote' => 'required|integer',
        ]); */
        if ($request->q=='form_data') {
            $contestant = Contestant::where('id', $id)->first();
            $contestant->form_data = json_encode($request->form_data);
            $contestant->save();
            return "form saved";
        } else {
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
            ]);
            
            $contestant = Contestant::findOrFail($id);
            $contestant->name=$request->name;
            $contestant->email=$request->email;
            $contestant->phone=$request->phone;
            if ($request->hasFile('avatar')) {
                $contestant->avatar = custom_file_upload($request->avatar,CONTESTANT_IMAGE_PATH,$contestant->id);
                
            }
            $contestant->save();
            return back()->with('success','Data updated successfully');
        }
        
    }

    public function updateVote(Request $request,$id)
    {
        /* $this->validate($request, [
            'vote' => 'required|integer',
        ]); */
        
        $contestant = Contestant::findOrFail($id);
        $contestant->votes=$contestant->votes +1;

        $contestant->save();

        // $mailer->sendTicketInformation(Auth::user(), $ticket);

        return "success";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CreatyDev\Domain\Contestant  $contestant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contest=Contestant::findOrFail($id);
        if($contest){
            $contest->delete();
        }
        return redirect()->back()->with("status", "contest deleted.");
    }
}
