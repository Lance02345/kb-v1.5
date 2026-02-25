<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\County;
use Illuminate\Http\Request;

class CountyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['counties'] = County::orderBy('county')->get();
        return view ('admin.county.index') ->with($arr);
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.county.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, County $county)
    {
        $validatedData= $this->validate($request,[
            'county' => 'required',
            'country' => 'required',
            ]);

        County::create($validatedData);
      return redirect() -> route('admin.county.index')->with('success','New County Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\County  $county
     * @return \Illuminate\Http\Response
     */
    public function show(County $county)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\County  $county
     * @return \Illuminate\Http\Response
     */
    public function edit(County $county)
    {
        $arr['county'] = $county;
        return view('admin.county.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\County  $county
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, County $county)
    {
        $validatedData = $this->validate($request,[
            'county' => 'required',
            'country' => 'required',
            ]);

      $county->update($validatedData);
      return redirect() -> route('admin.county.index')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\County  $county
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        County::destroy($id);
        return redirect() -> route('admin.county.index');
    }
}
