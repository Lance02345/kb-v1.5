<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carmake;
use App\Models\Carmodel;
use Illuminate\Http\Request;

class CarmodelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['carmakes'] = Carmake::query()->orderBy('make')->get();
        $arr['carmodels'] = Carmodel::query()->with('carmake')->latest()->get();
        return view ('admin.carmodel.index') ->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arr['carmakes'] = Carmake::query()->orderBy('make')->get();
        return view('admin.carmodel.create')->with($arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'model' => 'required|string|max:80',
            'model_year' => 'required|integer|min:1900|max:2100',
            'make_id' => 'required|exists:carmakes,id',
        ]);
       Carmodel::create($validatedData);
       return redirect() -> route('admin.carmodel.index')->with('success','Succesfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Carmodel $carmodel)
    {
        $arr['carmakes'] = Carmake::query()->orderBy('make')->get();
        $arr['carmodel'] = $carmodel;
        return view('admin.carmodel.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carmodel $carmodel)
    {
        $validatedData = $this->validate($request, [
            'model' => 'required|string|max:80',
            'model_year' => 'required|integer|min:1900|max:2100',
            'make_id' => 'required|exists:carmakes,id',
        ]);
       $carmodel->update($validatedData);
       return redirect() -> route('admin.carmodel.index')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Carmodel::destroy($id);
        return redirect() -> route('admin.carmodel.index')->with('success','Car model deleted successfully');
    }
}
