<?php

namespace CreatyDev\Http\Auth\Controllers;

use Illuminate\Http\Request;
use CreatyDev\App\Controllers\Controller;
use Sarfraznawaz2005\VisitLog\Facades\VisitLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated. 
     *
     * @param Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $subscription = auth()->user()->subscriptions()->first();
        // dd($subscription);
        if($subscription && in_array($subscription->stripe_plan , ['Gold','Premium'] )){
            if( ( is_null($subscription->trial_ends_at) || !$subscription->trial_ends_at->isFuture() )&& is_null($subscription->ends_at)){
                $subscription->cancel();
            }
            // dd('gold','premium');
        }  
        // dd($subscription->stripe_plan);
        VisitLog::save();
        if (auth()->user()->hasRole('admin-root') ) {
            // return redirect()->intended('/admin/dashboard');
            $url = '/admin/dashboard';
            return redirect()->intended($url);
        } 
        elseif(auth()->user()->hasRole('admin')) 
        {
            // return redirect()->intended('/account/dashboard');
            $url = '/account/dashboard';
            return redirect()->intended($url);
        }

        else {
            $request->session()->flash('error', 'Sorry,Login Unuccessfull!');
            return redirect()->back();
        }
        //prevent user login if not activated
        if ($user->hasNotActivated()) {
            // dd("true");
            //log user out
            $this->guard()->logout();

            //redirect with error
            return back()->withInput(['email'])
                ->withError('Your account is not active. Please activate it first.');
        }
        return redirect()->intended($url);
        if ($user->twoFactorEnabled()) {
            return $this->startTwoFactorAuthentication($request, $user);
        }

    }

    protected function startTwoFactorAuthentication(Request $request, $user)
    {
        session()->put('twofactor', (object)[
            'user_id' => $user->id,
            'remember' => $request->has('remember')
        ]);

        $this->guard()->logout();

        return redirect()->route('login.twofactor.index');
    }
}
