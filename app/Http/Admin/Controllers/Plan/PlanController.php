<?php

namespace CreatyDev\Http\Admin\Controllers\Plan;

use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Subscriptions\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Stripe;
use Doctrine\DBAL\Schema\View;

class PlanController extends Controller
{
    public function __construct(){

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('create', Plan::class);

        $plans = Plan::all();

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Plan::class);

        return view('admin.plans.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* dd($request->all()); */
        $this->authorize('create', Plan::class);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',
            // 'trial' => 'present'
            // 'plan_type' => 'required',Rule::in(['one_time','recurring'])
        ]);
            // Generate pla slug from plan name
        $slug = str_replace(' ','-', $request->input('name'));
        $gateway_id = str_replace(' ','_', $request->input('name'));
        //$team_enable = !empty($request->input('teams_limit')) ? 1 : 0;
        //$teams_limit = !empty($request->input('teams_limit')) ? $request->input('teams_limit') : NULL;
        $price = (float) $request->input('price') * 100;
        
        $interval=explode(',',$request->duration);
       /*  dd($interval); */
        //Add the Stripe Api key to create the plan on the stripe dashboard
        // if($request->plan_type == "recurring"){
        \Stripe\Plan::create([
            "amount" => $price,
            "interval" => $interval[1],
            "interval_count"=>$interval[0], 
            "product" => [
                "name" => $request->name,
            ],
            "trial_period_days" => $request->trial,
            "currency" => "usd",
            "id" => $gateway_id,
            //"trial_period_days" => $request->input('trial'),
        ]);
        // }elseif($request->plan_type == "one_time"){
        //     \Stripe\Product::create([
        //         "name" => $request->name,
        //         "id" => $gateway_id,
        //     ]);
        //     \Stripe\Price::create([
        //         "unit_amount" => $price,
        //         "currency" => "usd",
        //         "product" => $gateway_id,
        //     ]);
        // }
        /* dd(123); */
        $plan = new Plan([
            'name' => $request->name,
            'gateway_id' => $gateway_id,
            'price' => $request->price,
            'brand' => $request->brand,
            'contest' => $request->contest,
            'duration' => $request->duration,
            'other_info_1' => $request->plan_info_1,
            'other_info_2' => $request->plan_info_2,
            //'teams_enabled' => $team_enable,
            //'teams_limit' => $teams_limit,
            'active' => 1,
            'slug' => $slug,
            'trial_period_days' => $request->trial,
        ]);

        $plan->save();

        return redirect()->back()->with("status", "Your plan has been created.");
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
        $this->authorize('update', Plan::class);

        $plan = Plan::findOrFail($id);

        return view('admin.plans.edit', compact('plan', $plan));
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
        $this->authorize('update', Plan::class);

        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',
        ]);

        $plan = Plan::findOrFail($id);
        // Generate plan slug from plan name
        $slug = str_replace(' ','-', $request->input('name'));
        $gateway_id = str_replace(' ','_', $request->input('name'));
        $team_enable = !empty($request->input('teams_limit')) ? 1 : 0;
        $teams_limit = !empty($request->input('teams_limit')) ? $request->input('teams_limit') : NULL;
        $price = (float) $request->input('price') * 100;
        
        // Delete the plan on stripe 
        $stripe_plan = \Stripe\Plan::retrieve($plan->gateway_id);
        $stripe_plan->delete();

        $interval=explode(',',$request->duration);
        //Add the Stripe Api key to
        // Recrete a new plan on stripe
        \Stripe\Plan::create([
            "amount" => $price,
            "interval" => $interval[1],
            "interval_count"=>$interval[0], 
            "product" => [
                "name" => $request->input('name'),
            ],
            "currency" => "usd",
            "id" => $gateway_id,
            "trial_period_days" => $request->input('trial'),
        ]);

        $plan->name = $request->input('name');
        $plan->gateway_id = $gateway_id;
        $plan->price = $request->input('price');
        $plan->brand = $request->input('brand');
        $plan->contest = $request->input('contest');
        $plan->duration = $request->input('duration');
        $plan->other_info_1 =$request->input('plan_info_1');
        $plan->other_info_2 = $request->input('plan_info_2');
        //$plan->teams_enabled = $team_enable;
        //$plan->teams_limit = $teams_limit;
        $plan->active =1;
        $plan->slug = $slug;
        //$plan->trial_period_days = $request->input('trial');
        $plan->save();

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
        $this->authorize('delete', Plan::class);
        $plan = Plan::findOrFail($id);

        //Add the Stripe Api key to create/delete the plan on the stripe dashboard
        //$stripe_plan = \Stripe\Plan::retrieve($plan->gateway_id);
        //$stripe_plan->delete();

        // Delete the plan on the database
        $plan->delete();
        return redirect()->back()->with("status", "Your plan has been deleted.");
    }
}
