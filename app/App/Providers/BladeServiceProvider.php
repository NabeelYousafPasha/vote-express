<?php

namespace CreatyDev\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //user is subscribed
        Blade::if ('impersonating', function () {
            return session()->has('impersonate');
        });

        //user is subscribed
        Blade::if ('subscribed', function () {
            return auth()->user()->hasSubscription();
        });

        //user does not have subscription
        Blade::if ('notsubscribed', function () {
            return !auth()->check() || auth()->user()->doesNotHaveSubscription();
        });

        //user has cancelled subscription
        Blade::if ('subscriptioncancelled', function () {
            // $subscription = auth()->user()->subscriptions()->first();
            // if($subscription){
            //     $onetime = in_array($subscription->stripe_plan , ['gold','premium'] );
            //     return (auth()->user()->hasCancelled() && !$onetime);
            // }else{
                return auth()->user()->hasCancelled();
            // }
        });

        // check for gold and premium subscription
        Blade::if('specificsubscription',function(){
            $subscription = auth()->user()->subscriptions()->first();
            if($subscription){
                $onetime = in_array($subscription->stripe_plan , ['Gold','Premium'] );
                return !$onetime;
            }
            return false;
        });

        //user has not cancelled subscription
        Blade::if ('subscriptionnotcancelled', function () {
            return !auth()->check() || auth()->user()->hasNotCancelled();
        });

        //user has a team subscription
        Blade::if ('teamsubscription', function () {
            return auth()->user()->hasTeamSubscription();
        });

        //user does not have a piggyback subscription
        Blade::if ('notpiggybacksubscription', function () {
            return !auth()->user()->hasPiggybackSubscription();
        });

        //user has a member of a team
        // TODO
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
