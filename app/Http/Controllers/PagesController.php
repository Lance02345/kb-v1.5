<?php

namespace App\Http\Controllers;
use App\Models\Carevent;
use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Category;
use App\Models\City;
use App\Models\Favourites;
use App\Models\Garage;
use App\Models\Listing;
use App\Models\Package;
use App\Models\SparePart;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Vehicle_photo;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\Intersection;

class PagesController extends Controller
{
    
Public function index (){
    $arr = $this->marketplacePayload();
    return view('modern.home')->with($arr);
}

public function marketplace()
{
    $arr = $this->marketplacePayload();
    return view('marketplace.index')->with($arr);
}

    public function updateUserLocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'label' => 'nullable|string',
        ]);

        session()->put('user_location', [
            'lat' => (float) $validated['latitude'],
            'lng' => (float) $validated['longitude'],
            'label' => $validated['label'] ?? null,
            'recorded_at' => now()->toDateTimeString(),
        ]);

        return response()->json(['status' => 'ok']);
    }

    private function marketplacePayload()
    {
        $nearbyHint = trim((string) (request('city') ?: request('location') ?: ''));
        $userLocation = $this->normalizeUserLocation(session('user_location'));
        $arr['nearbyCity'] = $this->resolveNearbyCityLabel($nearbyHint, (bool) $userLocation, $userLocation);
        $arr['cities'] = City::orderBy('city')->get();
        $arr['makes'] = Carmake::orderBy('make')->get();
        $arr['models'] = Carmodel::orderBy('model')->get();
        $arr['carevents'] = Carevent::query()->with('user')->latest('id')->take(6)->get();
        $arr['latestSpareParts'] = SparePart::query()->latest('id')->take(6)->get();
        $arr['latestGarages'] = Garage::query()->with('user')->latest('id')->take(8)->get();
        $arr['nearbyGarages'] = $this->fetchNearbyItems(Garage::class, ['user'], $nearbyHint, $userLocation, 'garage_location');
        $arr['nearbyParts'] = $this->fetchNearbyItems(SparePart::class, ['user'], $nearbyHint, $userLocation, 'location');

    $baseVehicleQuery = Vehicle::query()
        ->with(['carmodel.carmake', 'listing.category', 'listing.city', 'listing.package'])
        ->whereHas('listing', function ($query) {
            $query->where('category_id', 2)
                ->whereIn('ads_status', ['Approved', 'Active']);
        });

    $arr['featuredVehicles'] = (clone $baseVehicleQuery)
        ->whereHas('listing', function ($query) {
            $query->where('package_id', 2);
        })
        ->latest('id')
        ->take(9)
        ->get();

    $arr['latestVehicles'] = (clone $baseVehicleQuery)
        ->latest('id')
        ->take(12)
        ->get();

    return $arr;
}

    private function resolveNearbyCityLabel(string $hint, bool $hasCoords, ?array $location): string
    {
        if ($hint) {
            return Str::title($hint);
        }

        if ($hasCoords) {
            return $location['label'] ? Str::title($location['label']) : 'Your area';
        }

        return 'Kenya';
    }

    private function normalizeUserLocation($location): ?array
    {
        if (!is_array($location)) {
            return null;
        }

        $lat = $location['lat'] ?? null;
        $lng = $location['lng'] ?? null;

        if ($lat === null || $lng === null) {
            return null;
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

        if ($lat === 0.0 && $lng === 0.0) {
            return null;
        }

        return [
            'lat' => $lat,
            'lng' => $lng,
            'label' => $location['label'] ?? null,
        ];
    }

    private function fetchNearbyItems(string $modelClass, array $relations, string $hint, ?array $coords, string $locationColumn, int $limit = 4)
    {
        $query = $modelClass::query()->with($relations);
        $nearby = $this->applyLocationOrdering(clone $query, $coords, $hint, $locationColumn)
            ->limit($limit)
            ->get();

        if ($coords && $nearby->count() < $limit) {
            $fallback = $query->whereNotIn('id', $nearby->pluck('id')->all())
                ->when($hint, fn ($sub) => $sub->where($locationColumn, 'like', '%' . $hint . '%'))
                ->orderBy('id', 'desc')
                ->limit($limit - $nearby->count())
                ->get();

            $nearby = $nearby->concat($fallback);
        }

        return $nearby;
    }

    private function applyLocationOrdering(Builder $query, ?array $coords, string $hint, string $locationColumn): Builder
    {
        if ($coords) {
            $lat = $coords['lat'];
            $lng = $coords['lng'];
            $distanceSql = '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))';

            return $query->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->orderByRaw("{$distanceSql} asc", [$lat, $lng, $lat]);
        }

        if ($hint) {
            return $query->where($locationColumn, 'like', '%' . $hint . '%')->orderBy('id', 'desc');
        }

        return $query->latest('id');
    }

public function carmodel(Request $request) {
    $data = Carmodel::select('model','id')->where('make_id',$request->id)->orderBy('model')->get();
    return response()->json($data);//then sent this data to aax success
}

Public function category (){
    $arr['vehicles'] = Vehicle::all();
    $arr['listings'] = Listing::all();
    return view ('pages.category')->with($arr);
    
}

public function showEventsPage()
{
    $carevents = Carevent::all();
    view()->share('pages.eventspage', $carevents);
 
}

Public function single (Vehicle $vehicle){
    $arr['vehicle'] = $vehicle;
    return view ('pages.single')->with($arr);
    
}
Public function houses (){

    return view ('pages.houses');
    
}

Public function about_us (){

    return view('modern.about');
    
}


Public function ad_list_view (){

    return view ('pages.ad_list_view');
    
}

Public function blog(){

    return view ('pages.blog');
    
}

Public function contact_us(){

    return view ('pages.contact_us');
     
}
public function vehicle_search(Request $request)
{
    $cities = City::orderBy('city')->get();
    $makes = Carmake::orderBy('make')->get();
    $models = Carmodel::orderBy('model')->get();
    $vehicles = collect();

    $listingsQuery = Listing::with(['category', 'city', 'vehicles.carmodel.carmake'])
        ->where('category_id', 2)
        ->whereNotNull('city_id');

    if ($request->filled('city')) {
        $listingsQuery->where('city_id', $request->city);
    }

    if ($request->filled('model_id')) {
        $listingsQuery->whereHas('vehicles', function ($query) use ($request) {
            $query->where('model_id', $request->model_id);
        });
    }

    if ($request->filled('min_price')) {
    $minPrice = str_replace(',', '', $request->input('min_price'));
    $listingsQuery->whereHas('vehicles', function ($query) use ($minPrice) {
        $query->where('price', '>=', $minPrice);
    });
}

// Search by maximum price
if ($request->filled('max_price')) {
    $maxPrice = str_replace(',', '', $request->input('max_price'));
    $listingsQuery->whereHas('vehicles', function ($query) use ($maxPrice) {
        $query->where('price', '<=', $maxPrice);
    });
}

    $listings = $listingsQuery->orderBy('id', 'desc')->paginate(16);
    $vehicles = Vehicle::with('carmodel.carmake')
        ->whereIn('listing_id', $listings->pluck('id'))
        ->get();

    return view('pages.vehicleslist', compact('cities', 'makes', 'models', 'listings', 'vehicles'));
}

public function listing_filter(Request $request){
    $arr['vehicles'] = Vehicle::all();
    $arr['listings'] = Listing::where('category_id',2)->Where('city_id',$request->id)->take(18)->get(); 
    $arr['cities'] = City::orderBy('city')->get();
    $arr['makes'] = Carmake::orderBy('make')->get();
    $arr['models'] = Carmodel::orderBy('model')->get();
    return view ('pages.vehicleslist')->with($arr);
}
public function vehicle_filter(Request $request){
    $arr['makes'] = Carmake::orderBy('make')->get();
    $arr['models'] = Carmodel::orderBy('model')->get();
    $arr['listings'] = Listing::where('category_id',2)->take(18)->get(); 
    $arr['vehicles'] = Vehicle::where('model_id', $request->id)->take(20)->get();
    $arr['cities'] = City::orderBy('city')->get();
    return view ('pages.vehicleslist')->with($arr);
}

Public function vehicleslist(){
    $arr['makes'] = Carmake::orderBy('make')->get();
    $arr['models'] = Carmodel::orderBy('model')->get();
    $arr['cities'] = City::orderBy('city')->get();
    $arr['listings'] = Listing::with(['category', 'city', 'vehicles.carmodel.carmake'])
        ->where('category_id', 2)
        ->paginate(20);
    $arr['vehicles'] = Vehicle::with('carmodel.carmake')
        ->whereIn('listing_id', $arr['listings']->pluck('id'))
        ->get();
   // $arr['carcities'] = Listing::where('category_id',2)->where('city_id',$request->city_id)->take(20)->get();
   $arr['imgcount'] = Vehicle::where(['front_img' => Null,'back_img'=> Null, 'right_img'=> Null, 'left_img'=> Null])->count();
  
    $arr['vehiclephotos'] = Vehicle_photo::where('photo_postion',1)->get();
    return view ('pages.vehicleslist')->with($arr);
    
}
Public function vehicles_list(){
    $arr['cities'] = City::orderBy('city')->get();
    $arr['vehicles'] = Vehicle::all();
    $arr['listings'] = Listing::where('category_id',2)->take(20)->get(); //the 2 is the id of car category
  
    $arr['vehiclephotos'] = Vehicle_photo::where('photo_postion',1)->get();
    return view ('pages.vehicles_list')->with($arr);
    
}
    public function vehicle(Listing $listing, Vehicle $vehicle){
        $vehicle->increment('views');
        $vehicle->save();
        $listing->loadMissing('user');
        $arr['listing'] = $listing;
        $arr['vehicle'] = $vehicle;
        $arr['vehiclephotos'] = Vehicle_photo::all();

        $listingCityId = $listing->city_id;
        $makeName = optional(optional($vehicle->carmodel)->carmake)->make;

        $arr['similarVehicles'] = Vehicle::query()
            ->with(['carmodel.carmake', 'listing.city'])
            ->where('id', '!=', $vehicle->id)
            ->whereHas('listing', fn ($query) => $query->where('category_id', 2))
            ->when($makeName, fn ($query) => $query->whereHas('carmodel.carmake', fn ($sub) => $sub->where('make', $makeName)))
            ->when($listingCityId, fn ($query) => $query->whereHas('listing', fn ($sub) => $sub->where('city_id', $listingCityId)))
            ->latest('id')
            ->take(4)
            ->get();

        return view ('pages.vehicle')->with($arr);
    }

    public function seller(User $user)
    {
        $sellerVehicleListings = Vehicle::query()
            ->with(['carmodel.carmake', 'listing.city', 'listing.category', 'listing.user'])
            ->whereHas('listing', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('category_id', 2)
                    ->whereIn('ads_status', ['Approved', 'Active']);
            })
            ->latest('id')
            ->get();

        $sellerSpareParts = SparePart::query()
            ->with('user')
            ->where('user_id', $user->id)
            ->latest('id')
            ->get();

        return view('modern.seller', [
            'seller' => $user,
            'sellerVehicleListings' => $sellerVehicleListings,
            'sellerSpareParts' => $sellerSpareParts,
        ]);
    }

Public function carhire(){
    return redirect()->route('marketplace.index')->with('info', 'Car hire is temporarily unavailable.');
}
Public function carhirelist() {
    return redirect()->route('marketplace.index')->with('info', 'Car hire is temporarily unavailable.');
}
Public function showcarhire(Listing $listing, Vehicle $vehicle) {
    return redirect()->route('marketplace.index')->with('info', 'Car hire is temporarily unavailable.');
}

Public function post_ad_form(){

    return view ('pages.post_ad_form');
    
}

Public function dashboard_archived_ads(){

    return view ('pages.dashboard_archived_ads');
    
}



public function addToFavorites(Request $request)
{
    // Get the user ID of the authenticated user
    $userId = Auth::id();

    // Get the vehicle ID from the request
    $vehicleId = $request->input('vehicle_id');

    // Check if the user has already favorited the vehicle
    $existingFavorite = Favourites::where('user_id', $userId)
        ->where('vehicle_id', $vehicleId)
        ->first();

    if ($existingFavorite) {
        // The user has already favorited this vehicle, no need to add it again
        return back()->with('info', 'Vehicle is already in favorites.');
    }

    // If the vehicle is not already favorited, add it to favorites
    $favorite = new Favourites();
    $favorite->user_id = $userId;
    $favorite->vehicle_id = $vehicleId;
    $favorite->save();

    return back()->with('success', 'Vehicle added to favorites.');
}

public function removeFromFavorites(Request $request)
{
    $userId = Auth::id();
    $vehicleId = $request->input('vehicle_id');
    $favorite = Favourites::where('user_id', $userId)
        ->where('vehicle_id', $vehicleId)
        ->first();

    if ($favorite) {
        $favorite->delete();
        return back()->with('success', 'Vehicle removed from favorites.');
    }

    return back()->with('info', 'Vehicle was not found in your favorites.');
}






Public function dashboard_favorites(){

    return view ('pages.dashboard_favourites');
    
}




Public function dashboard_my_ads(){

    return view ('pages.dashboard_my_ads');
    
}


Public function dashboard(){

    return view ('pages.dashboard');
    
}
Public function signup(){

    return view('auth.register');
    
}

public function storeuser(Request $request, User $user)
{
    $validatedData = $this->validate($request, [
        'name' => 'required|max:255',
        'email' => 'required|unique:users|email|max:255',
        'password' => 'required|between:8,255|confirmed',
        'password_confirmation' => 'required',
        'phone_number' => 'required',
        'identification_number' => '',
        'kra_pin' => '',  
        'role' => 'required',
    ]);

    // Check if the phone number starts with '+254'
    $phoneNumber = $validatedData['phone_number'];
    if (!str_starts_with($phoneNumber, '+254')) {
        // If it doesn't start with '+254', prepend it
        $phoneNumber = '+254' . $phoneNumber;
    }

    $validatedData['phone_number'] = $phoneNumber; // Update the phone_number in the validated data

    $user = User::create($validatedData);
    $user->roles()->sync($request->input('role',[]));

    return redirect()->route('user.my_list')->with('success', 'Successfully Added');
}

  
    


Public function login(){

    return view('auth.login');
    
}

public function events(){
    return view ('pages.eventspage');
}

public function show($id)
{
    $carevent = Carevent::with('user')->findOrFail($id);
    return view('modern.single_event', compact('carevent'));
}

Public function register(){

    return view('auth.register');
    
}

Public function single_blog(){

    return view ('pages.single_blog');
    
}

Public function terms_condition(){

    return view ('pages.terms_condition');
    
}


public function package (){
    return view ('pages.package');
    
}

}
