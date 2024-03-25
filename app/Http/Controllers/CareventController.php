<?php

namespace App\Http\Controllers;

use App\Models\Carevent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CareventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carevents = Carevent::all(); // Replace with your actual logic to fetch events
        return view('pages.eventspage', ['carevents' => $carevents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_carevent()
    {
        return view('user.create_carevent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_carevent(Request $request, Carevent $carevent)
    {
        $this->validate($request, [
            'event_title' => 'required',
            'event_description' => 'required',
            'event_location' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'organizer' => 'required',
            'event_duration' => 'required',
            'user_id' => 'required', 

            'event_image' => ' required|image|max:2048|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if($request->hasFile('event_image')){
            $imagenamewithExt = $request->file('event_image')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('event_image')->getClientOriginalExtension();
            $event_imageStore = $imagename.'_'.time().'.'.$extension;
            $path = $request->file('event_image')->storeAs('public/photos', $event_imageStore);
        } 

        $carevent->event_title = $request->event_title;
        $carevent->event_description = $request->event_description;
        $carevent->event_location = $request->event_location;
        $carevent->event_date = $request->event_date;
        $carevent->event_time = $request->event_time;
        $carevent->organizer = $request->organizer;
        $carevent->ticket_price = $request->ticket_price;
        $carevent->event_duration = $request->event_duration;
        $carevent->user_id = $request->user_id;
    
        if($request->hasFile('event_image')) { $carevent->event_image = $event_imageStore; }

        $carevent->save();
        return redirect() -> route('user.carevent')->with('success','Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carevent  $carevent
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carevent  $carevent
     * @return \Illuminate\Http\Response
     */
    public function edit_carevent(Carevent $carevent)
    {

        $arr['carevent'] = $carevent;
        return view('user.edit_carevent')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carevent  $carevent
     * @return \Illuminate\Http\Response
     */
    public function update_carevent(Request $request, Carevent $carevent)
    {
        $this->validate($request, [
            'event_title' => 'required',
            'event_description' => 'required',
            'event_location' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'organizer' => 'required',
            'event_duration' => 'required',
            'user_id' => 'required', 

        ]);

        if($request->hasFile('event_image')){
            $imagenamewithExt = $request->file('event_image')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('event_image')->getClientOriginalExtension();
            $event_imageStore = $imagename.'_'.time().'.'.$extension;
            $path = $request->file('event_image')->storeAs('public/photos', $event_imageStore);
        } 

        $carevent->event_title = $request->event_title;
        $carevent->event_description = $request->event_description;
        $carevent->event_location = $request->event_location;
        $carevent->event_date = $request->event_date;
        $carevent->event_time = $request->event_time;
        $carevent->organizer = $request->organizer;
        $carevent->ticket_price = $request->ticket_price;
        $carevent->event_duration = $request->event_duration;
        $carevent->user_id = $request->user_id;
    
        if($request->hasFile('event_image')) { $carevent->event_image = $event_imageStore; }

        $carevent->update();
        return redirect() -> route('user.edit_carevent',$carevent->id)->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carevent  $carevent
     * @return \Illuminate\Http\Response
     */
    public function delete_carevent(Carevent $carevent)
    {
        $carevent = Carevent::find($carevent);

    Storage::delete(
    'public/photos/'.$carevent->event_image
    );

    $carevent->delete();
    return redirect()->route('user.carevent')->with('success','removed successfully');

    }
}
