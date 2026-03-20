<?php

namespace App\Http\Controllers;

use App\Models\Carevent;
use App\Support\JourneyMailer;
use App\Support\ListingBilling;
use App\Support\OptimizedImageStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CareventController extends Controller
{
    public function __construct(private OptimizedImageStore $optimizedImageStore)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carevents = Carevent::query()->with('user')->latest('id')->get();
        return view('modern.events', ['carevents' => $carevents]);
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

            'event_image' => ' required|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heic,heif',
        ]);

        $eventImageStore = null;
        if ($request->hasFile('event_image')) {
            $eventImageStore = $this->storeProcessedEventImage($request->file('event_image'));
        }

        DB::transaction(function () use ($request, $carevent, $eventImageStore) {
            $carevent->event_title = $request->event_title;
            $carevent->event_description = $request->event_description;
            $carevent->event_location = $request->event_location;
            $carevent->event_date = $request->event_date;
            $carevent->event_time = $request->event_time;
            $carevent->organizer = $request->organizer;
            $carevent->ticket_price = $request->ticket_price;
            $carevent->event_duration = $request->event_duration;
            $carevent->user_id = $request->user_id;
        
            if ($eventImageStore) { $carevent->event_image = $eventImageStore; }

            $carevent->save();

            $billing = ListingBilling::createFreeForUser((int) $request->user_id, 7);
            $carevent->listing_id = $billing['listing']->id;
            $carevent->invoice_id = $billing['invoice']->id;
            $carevent->save();

            $billing['invoice']->load('user', 'package');
            JourneyMailer::sendInvoiceGenerated($billing['invoice']);
        });

        $carevent->load('user');
        JourneyMailer::sendCareventSubmitted($carevent);
        return redirect() -> route('user.carevent')->with('success','Added Successfully. Free package + invoice applied.');
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

        $eventImageStore = null;
        if ($request->hasFile('event_image')) {
            $eventImageStore = $this->storeProcessedEventImage($request->file('event_image'));
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
    
        if ($eventImageStore) { $carevent->event_image = $eventImageStore; }

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

    private function storeProcessedEventImage($image): string
    {
        return basename($this->optimizedImageStore->storePublicImage($image, 'photos', 'event_image'));
    }
}
