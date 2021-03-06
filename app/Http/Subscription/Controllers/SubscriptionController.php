<?php

namespace CreatyDev\Http\Subscription\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Subscriptions\Models\Plan;
use CreatyDev\Domain\Subscriptions\Requests\SubscriptionStoreRequest;


class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user();
        /* dd(444); */
        return view('subscriptions.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubscriptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionStoreRequest $request)
    {
        $plan = plan::where('slug',$request->plan)->first();

        /* dd($customer = auth()->user()->asStripeCustomer()); */
        $subscription = $request->user()->newSubscription('main', $request->plan);
        // $user = User::find(1);

        // $subscription = $request->user()->newSubscription('main', 'premium')->create($paymentMethod);

        if($request->has('coupon')) {
            $subscription->withCoupon($request->coupon);
        }
        if($plan && !is_null($plan->trial_period_days)) {
            $subscription->trialDays($plan->trial_period_days);
        }
        // dd('notrail');
        $subscription->create($request->token);

        return redirect()->route('account.dashboard')->withSuccess('Thanks for becoming a subscriber.');
    }
}
