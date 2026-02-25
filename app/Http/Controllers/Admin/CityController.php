<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\County;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['cities'] = City::with('county')->orderBy('city')->get();
        return view ('admin.city.index') ->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arr['counties'] = County::orderBy('county')->get();
        return view('admin.city.create')->with($arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validatedata = $this->validate($request,[
            'city' => 'required',
            'county_id' => 'required',
            ]);

        City::create($validatedata);
        return redirect() -> route('admin.city.index')->with('success','New City Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $arr['city'] = $city;
        $arr['counties'] = County::orderBy('county')->get();
        return view('admin.city.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $validatedata = $this->validate($request,[
            'city' => 'required',
            'county_id' => 'required',
            ]);
        $city->update($validatedata);
        return redirect() -> route('admin.city.index')->with('success','Updated Successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        City::destroy($id);
        return redirect() -> route('admin.city.index');
    }
}
