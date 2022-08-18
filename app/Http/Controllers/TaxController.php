<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Services\TaxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    public $taxService;

    public function __construct()
    {
        $this->taxService = new TaxService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $taxes = new Tax();

        if($request->q) {
            $taxes = $taxes->where('name','like','%'.$request->q.'%');
        }

        $taxes = $taxes->paginate($request->offset ?? 20);

        return view('setting.tax.index',compact('taxes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'percent' => 'required|numeric|min:1'
        ]);

        $this->taxService->create($request->all());

        return redirect()->back()->with('success','Data created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        $request->validate([
            'name' => 'required',
            'percent' => 'required|numeric'
        ]);

        $this->taxService->update($request->all(), $tax);
        
        return redirect()->back()->with('success','Data updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        $this->taxService->destroy($tax);

        return redirect()->back()->with('success', 'Data deleted');
    }
}
