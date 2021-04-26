<?php

namespace CreatyDev\Http\Middleware\Subscription;

use Closure;

class RedirectIfCancelled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $subscription = auth()->user()->subscriptions()->first();
        if($subscription){
            $onetime = in_array($subscription->stripe_plan , ['gold','premium','notrail2','notrail1'] );
        }
        if (!auth()->user()->hasSubscription() || (auth()->user()->hasCancelled() && !$onetime)) {
            return redirect()->route('plans.index')
                    ->withSuccess('You need to be subscribed to access this feature.');
        }

        return $next($request);
    }
}
