<?php

namespace CreatyDev\Http\Admin\Controllers\Subscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CreatyDev\App\Controllers\Controller;

use CreatyDev\Domain\Users\Models\User;
use CreatyDev\Domain\Subscriptions\Models\Subscription;

use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Display all Subscription view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions =  DB::table('subscriptions')->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $all_users=User::all();
        return view('admin.subscriptions.create',compact('all_users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required',
            'stripe_id' => 'required',
            'stripe_plan' => 'required',
            'ends_at' =>'date|required'
        ]);
        
        $subscription = new Subscription([
            'user_id' => $request->input('client_id'),
            'stripe_id' => $request->input('stripe_id'),
            'stripe_plan' => $request->input('stripe_plan'),
            'ends_at' => Carbon::parse($request->input('ends_at'))->toDateTimeString(),
        ]);

        $subscription->save();

        return redirect()->back()->with("status", "Client Subscription has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \CreatyDev\Domain\Users\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        $this->authorize('view', $plan);

        return view('admin.plans.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\Users\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);

        return view('admin.subscriptions.edit', compact('subscription', $subscription));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \CreatyDev\Domain\Users\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'client_id' => 'required',
            'stripe_id' => 'required',
            'stripe_plan' => 'required',
            'ends_at' =>'date|required'
        ]);
        

        $subscription = Subscription::findOrFail($id);

        $subscription->user_id = $request->input('client_id');
        $subscription->stripe_id = $request->input('stripe_id');
        $subscription->stripe_plan = $request->input('stripe_plan');
        $subscription->ends_at = Carbon::parse($request->input('ends_at'))->toDateTimeString();
        $subscription->save();

        return redirect()->back()->with("status", "Your plan has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CreatyDev\Domain\Users\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        // Delete the plan on the database
        $subscription->delete();
        return redirect()->back()->with("status", "Client Subscription has been deleted.");
    }
}
