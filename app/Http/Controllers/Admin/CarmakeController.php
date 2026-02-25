<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carmake;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class CarmakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['carmakes'] = Carmake::query()->latest()->get();
        return view ('admin.carmake.index') ->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.carmake.create');
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
            'make' => 'required|string|max:80|unique:carmakes,make',
        ]);
    
      Carmake::create($validatedData);
      return redirect() -> route('admin.carmake.index')->with('success','Succesfully Added');
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
    public function edit(Carmake $carmake)
    {
        $arr['carmake'] = $carmake;
        return view('admin.carmake.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carmake $carmake)
    {
        $validatedData = $this->validate($request, [
            'make' => 'required|string|max:80|unique:carmakes,make,' . $carmake->id,
        ]);
    
        $carmake->update($validatedData);
        return redirect() -> route('admin.carmake.index')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Carmake::destroy($id);
        return redirect() -> route('admin.carmake.index')->with('success','Car make deleted successfully');
    }
}
