<?php

namespace CreatyDev\Http\Account\Controllers;

use CreatyDev\App\Controllers\Controller;
use CreatyDev\Domain\Account\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('subscription.active');
    }

    public function index()
    {
        $brands = Brand::where('user_id',auth()->user()->id)->paginate(4);
        $table = [
            'fields' => [
                'title' => 'Event Title',
                'desc' => 'Description',
                'street_address' => null,
                'city' => null,
                'country' => null,
            ],
            'action' => [
                'route_name_edit' => 'account.brand.edit',
                'route_name_delete' => 'account.brand.destroy',
                'route_name_show' => 'account.brand.show',
                'key_name' => 'id', // 'id' by default
            ]
        ];
        $title = 'Brand';
        $titles = 'Brands';
        return view('account.brands.index', compact('brands','title','titles','table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Brand';
        $titles = 'Brands';
        return view('account.brands.create',compact('title','titles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'desc' => 'required|string|max:191',
        ]);

        $brand = new Brand([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'user_id' => Auth::user()->id,
        ]);

        $brand->save();

        // $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect()->back()->with("status", "Brand has been submitted.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \CreatyDev\Domain\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'show';
        $brand=Brand::findOrFail($id);
        if($brand){
            $brand->delete();
        }
        return redirect()->back()->with("status", "Brand updated.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CreatyDev\Domain\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Brand';
        $titles = 'Brands';
        $brand = Brand::findOrFail($id);

        return view('account.brands.edit', compact('brand','title','titles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CreatyDev\Domain\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'desc' => 'required|string|max:191',
        ]);
        
        $brand = Brand::findOrFail($id);

        $brand->name = $request->input('name');
        $brand->desc = $request->input('desc');
        $brand->user_id  = Auth::user()->id;

        $brand->save();

        // $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect('account/brands')->with("status", "Brand has been updated.");
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
        $brand=Brand::findOrFail($id);
        if($brand){
            $brand->delete();
        }
        return redirect('/account/brands')->with("status", "Brand deleted.");
    }
}
