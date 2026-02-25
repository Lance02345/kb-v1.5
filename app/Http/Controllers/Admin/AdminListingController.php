<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Vehicle;
use App\Support\JourneyMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminListingController extends Controller
{
    public function index(){
        $arr['listings'] = Listing::all();
        return view('admin.listing.index')->with($arr);
    }
    public function edit(Listing $listing){
        $arr['listing'] = $listing;
        return view('admin.listing.edit')->with($arr);
    }
    public function update(Listing $listing, Request $request){
        $oldStatus = $listing->ads_status;

        $validatedData = $this->validate($request, [
            'ads_status' => '',
            'ads_duration' => '',
            'ads_featured' => '',
            'package_id' => '',
            'user_id' => '',
            'status_reason' => 'nullable|string|max:500',
            
        ]);
        unset($validatedData['status_reason']);
    
      $listing->update($validatedData);

      if (strtoupper((string) $oldStatus) !== strtoupper((string) $listing->ads_status)) {
          $listing->load('user');
          JourneyMailer::sendListingStatusUpdated($listing, $oldStatus, $request->input('status_reason'));
      }

      return redirect() -> route('admin.listing.index')->with('success',' Listing updated');
    }
    public function vehicles(){
        
        $vehicles = DB::table('vehicles')
        ->join('listings', 'listings.id', '=', 'vehicles.listing_id')->where('category_id',2)
        ->get();
        return view('admin.listing.vehicles', compact('vehicles'));
    }

    public function carhirelist(){
        $arr['listings'] = Listing::where('category_id',4)->get();
        $arr['vehicles'] = Vehicle::all();
        return view('admin.listing.carhirelist')->with($arr);
    }
}
