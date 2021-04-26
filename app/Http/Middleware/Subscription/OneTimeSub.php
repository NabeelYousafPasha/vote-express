<?php

namespace CreatyDev\Http\Middleware\Subscription;

use Closure;

class OneTimeSub
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next,$subname)
    {
        dd($subname);
        // $subscription = auth()->user()->subscriptions()->first();
        // if($subscription){
        //     $onetime = in_array($subscription->stripe_plan , ['gold','premium'] );
        // }
        // if (!auth()->user()->hasSubscription() || (auth()->user()->hasCancelled() && !$onetime)) {
        //     return redirect()->route('plans.index');
        // }

        // return $next($request);
    }
}
