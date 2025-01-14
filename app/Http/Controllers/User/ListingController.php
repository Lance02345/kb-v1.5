<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use App\Exports\PackagesExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Category;
use App\Models\Favourites; // Import the Favorite model at the top of your controller
use App\Models\City;
use App\Models\Invoice;
use App\Models\Listing;
use App\Models\Package;
use App\Models\Carevent;
use Intervention\Image\Facades\Image;
use App\Models\Vehicle;
use App\Models\Vehicle_photo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\List_;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;



class ListingController extends Controller
{
    public function model(Request $request)
    {
        $data = Carmodel::select('model', 'id')->where('make_id', $request->id)->get();
        return response()->json($data);//then sent this data to aax success
    }
    public function my_list()
    {
        $arr['listings'] = Listing::where('user_id', Auth::id())->get();
        $arr['vehicles'] = Vehicle::all();
        $arr['vehiclephotos'] = Vehicle_photo::where('photo_postion', 1)->get();
        $current = Carbon::now();
        // $arr['exp_date'] = DB::table('listings')->whereRaw('DATEDIFF(created_at, current_date) > 60')->get();


        return view('user.my_list')->with($arr);


    }


    public function pending_list()
    {
        $listings = Listing::where('ads_status', 'pending')->where('user_id', Auth::id())->get();
        $vehicles = Vehicle::all();
        $vehiclephotos = Vehicle_photo::where('photo_postion', 1)->get();
        return view('user.pending_list', compact('listings', 'vehicles', 'vehiclephotos'));
    }

    public function active_list()
    {
        $listings = Listing::where('ads_status', 'Active')->where('user_id', Auth::id())->get();
        $vehicles = Vehicle::all();
        return view('user.active_list', compact('listings', 'vehicles'));
    }
    public function sold_list()
    {
        $listings = Listing::where('ads_status', 'Sold')->where('user_id', Auth::id())->get();
        $vehicles = Vehicle::all();
        return view('user.sold_list', compact('listings', 'vehicles'));
    }
    public function expired_list()
    {
        $listings = Listing::where('ads_status', 'Expired')->where('user_id', Auth::id())->get();
        $vehicles = Vehicle::all();
        return view('user.expired_list', compact('listings', 'vehicles'));
    }
    public function archived_list()
    {
        $listings = Listing::where('ads_status', 'Archived')->where('user_id', Auth::id())->get();
        $vehicles = Vehicle::all();
        return view('user.archived_list', compact('listings', 'vehicles'));
    }
    public function userevent()
    {

        $carevents = Carevent::where('user_id', Auth::id())->get();
        return view('user.index_carevent', compact('carevents'));


    }


    public function favourites()
    {

        return view('user.favourites');

    }



    public function showFavoriteVehicles()
    {
        $user = auth()->user();
        $favoriteVehicles = $user->favorites; // Assuming you've defined the relationship in the User model

        $listings = Listing::all(); // Retrieve the listings data

        return view('user.favourites', compact('favoriteVehicles', 'listings'));
    }





    //Post the ad or the list page
    public function new_listing()
    {
        return view('user.new_listing');
    }
    public function index_vehiclesale()
    {
        $arr['listings'] = Listing::where('user_id', Auth::id())->get();
        $arr['vehicles'] = Vehicle::all();
        $arr['vehiclephotos'] = Vehicle_photo::where('photo_postion', 1)->get();
        $current = Carbon::now();
        // $arr['exp_date'] = DB::table('listings')->whereRaw('DATEDIFF(created_at, current_date) > 60')->get();


        return view('user.index_vehiclesale')->with($arr);
    }
    public function create_vehiclesale(Request $request)
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::select('model', 'id')->where('make_id', $request->id)->get(20);
        $arr['packages'] = Package::where('package_featured', null)->orderBy('id', 'desc')->get();
        return view('user.create_vehiclesale')->with($arr);
    }
    public function create_listing2()
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['packages'] = Package::where('package_featured', null)->orderBy('id', 'desc')->get();
        return view('user.create_listing2')->with($arr);
    }




    public function store_vehiclesale(Request $request, Listing $listing, Vehicle $vehicle)
    {
        Log::info('Starting store_vehiclesale process.');

        $this->validate($request, [
            'category' => 'required',
            'city' => 'required',
            'model_id' => 'required',
            'year_of_build' => 'required',
            'condition' => 'required',
            'mileage' => '',
            'transmission' => 'required',
            'fuel_type' => 'required',
            'exchange' => 'required',
            'price' => 'required',
            'description' => 'required',
            'body_type' => 'required',
            'duty_type' => 'required',
            'interior_type' => 'required',
            'engine_size' => 'required',
            'front_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'back_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'right_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'left_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'interiorf_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'interiorb_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'opt_img1' => '|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'opt_img2' => 'image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'opt_img3' => 'image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'vehicle_type' => 'required',
            'color' => 'required',
        ]);

        Log::info('Validation successful.');

        $listing->category_id = $request->category;
        $listing->city_id = $request->city;
        $listing->user_id = $request->user_id;
        $listing->ads_status = 'Pending';

        $listing->save();
        Log::info('Listing saved successfully.', ['listing_id' => $listing->id]);

        $currentId = $listing->id;

        $imageFields = ['front_img', 'back_img', 'right_img', 'left_img', 'interiorf_img', 'interiorb_img', 'engine_img', 'opt_img1', 'opt_img2', 'opt_img3'];

        foreach ($imageFields as $fieldName) {
            if ($request->hasFile($fieldName)) {
                try {
                    $image = $request->file($fieldName);
                    $imagename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $imageStore = $imagename . '_' . time() . '.' . $extension;

                    // Open the image using Intervention/Image
                    $img = Image::make($image);

                    // Load the watermark image
                    $watermark = Image::make(public_path('watermark/king.png'));

                    // Add the watermark to the image
                    $img->insert($watermark, 'bottom-right', 10, 10);

                    // Save the watermarked image
                    $img->save(public_path('storage/photos/' . $imageStore));

                    // Assign the image store path to the corresponding model field
                    $vehicle->$fieldName = $imageStore;

                    Log::info('Image processed and saved.', ['field' => $fieldName, 'filename' => $imageStore]);
                } catch (\Exception $e) {
                    Log::error('Error processing image.', [
                        'field' => $fieldName,
                        'message' => $e->getMessage(),
                    ]);
                }
            }
        }

        $price = str_replace(',', '', $request->input('price'));

        // Rest of your code to save the vehicle details
        $default_view = 0;

        $vehicle->listing_id = $currentId;
        $vehicle->model_id = $request->model_id;
        $vehicle->year_of_build = $request->year_of_build;
        $vehicle->title = $request->title;
        $vehicle->condition = $request->condition;
        $vehicle->mileage = $request->mileage;
        $vehicle->transmission = $request->transmission;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->exchange = $request->exchange;
        $vehicle->price = $price;
        $vehicle->description = $request->description;
        $vehicle->body_type = $request->body_type;
        $vehicle->duty_type = $request->duty_type;
        $vehicle->interior_type = $request->interior_type;
        $vehicle->engine_size = $request->engine_size;
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->color = $request->color;
        $vehicle->views = $default_view;

        $vehicle->save();
        Log::info('Vehicle saved successfully.', ['vehicle_id' => $vehicle->id]);

        return redirect()->route('user.packages', $currentId)->with('success', 'Added');
    }

    public function show_vehiclesale(Listing $listing, Vehicle $vehicle)
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['listing'] = $listing;
        $arr['vehicle'] = $vehicle;

        return view('user.show_vehiclesale')->with($arr);
    }

    public function edit_vehiclesale(Listing $listing, Vehicle $vehicle)
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['listing'] = $listing;
        $arr['packages'] = Package::all();
        $arr['vehicle'] = $vehicle;
        $arr['vehiclephotos'] = Vehicle_photo::all();

        return view('user.edit_vehiclesale')->with($arr);
    }
    public function update_vehiclesale(Request $request, Listing $listing, Vehicle $vehicle)
    {



        $listing->city_id = $request->city;
        $listing->update();

        $currentId = $listing->id;

        //Handle File Upload
        if ($request->hasFile('front_img')) {
            $imagenamewithExt = $request->file('front_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('front_img')->getClientOriginalExtension();
            $front_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('front_img')->storeAs('public/photos', $front_imgStore);
        }

        if ($request->hasFile('back_img')) {
            $imagenamewithExt = $request->file('back_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('back_img')->getClientOriginalExtension();
            $back_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('back_img')->storeAs('public/photos', $back_imgStore);
        }

        if ($request->hasFile('right_img')) {
            $imagenamewithExt = $request->file('right_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('right_img')->getClientOriginalExtension();
            $right_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('right_img')->storeAs('public/photos', $right_imgStore);
        }

        if ($request->hasFile('left_img')) {
            $imagenamewithExt = $request->file('left_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('left_img')->getClientOriginalExtension();
            $left_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('left_img')->storeAs('public/photos', $left_imgStore);
        }

        if ($request->hasFile('interiorf_img')) {
            $imagenamewithExt = $request->file('interiorf_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('interiorf_img')->getClientOriginalExtension();
            $interiorf_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('interiorf_img')->storeAs('public/photos', $interiorf_imgStore);
        }
        //interior back image upload code
        if ($request->hasFile('interiorb_img')) {
            $imagenamewithExt = $request->file('interiorb_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('interiorb_img')->getClientOriginalExtension();
            $interiorb_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('interiorb_img')->storeAs('public/photos', $interiorb_imgStore);
        }

        if ($request->hasFile('engine_img')) {
            $imagenamewithExt = $request->file('engine_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('engine_img')->getClientOriginalExtension();
            $engine_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('engine_img')->storeAs('public/photos', $engine_imgStore);
        }

        if ($request->hasFile('opt_img1')) {
            $imagenamewithExt = $request->file('opt_img1')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('opt_img1')->getClientOriginalExtension();
            $opt_img1Store = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('opt_img1')->storeAs('public/photos', $opt_img1Store);
        } else {
            $opt_img1Store = '';
        }

        if ($request->hasFile('opt_img2')) {
            $imagenamewithExt = $request->file('opt_img2')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('opt_img2')->getClientOriginalExtension();
            $opt_img2Store = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('opt_img2')->storeAs('public/photos', $opt_img2Store);
        } else {
            $opt_img2Store = '';
        }

        if ($request->hasFile('opt_img3')) {
            $imagenamewithExt = $request->file('opt_img3')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('opt_img3')->getClientOriginalExtension();
            $opt_img3Store = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('opt_img3')->storeAs('public/photos', $opt_img3Store);
        } else {
            $opt_img3Store = '';
        }


        $price = str_replace(',', '', $request->input('price'));


        $vehicle->listing_id = $currentId;
        $vehicle->model_id = $request->model_id;
        $vehicle->year_of_build = $request->year_of_build;
        $vehicle->condition = $request->condition;
        $vehicle->mileage = $request->mileage;
        $vehicle->transmission = $request->transmission;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->exchange = $request->exchange;
        $vehicle->price = $price;
        $vehicle->description = $request->description;
        $vehicle->body_type = $request->body_type;
        $vehicle->duty_type = $request->duty_type;
        $vehicle->interior_type = $request->interior_type;
        $vehicle->engine_size = $request->engine_size;
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->color = $request->color;

        if ($request->hasFile('front_img')) {
            $vehicle->front_img = $front_imgStore;
        }
        if ($request->hasFile('back_img')) {
            $vehicle->back_img = $back_imgStore;
        }
        if ($request->hasFile('right_img')) {
            $vehicle->right_img = $right_imgStore;
        }
        if ($request->hasFile('left_img')) {
            $vehicle->left_img = $left_imgStore;
        }
        if ($request->hasFile('interiorf_img')) {
            $vehicle->interiorf_img = $interiorf_imgStore;
        }
        if ($request->hasFile('interiorb_img')) {
            $vehicle->interiorb_img = $interiorb_imgStore;
        }
        if ($request->hasFile('engine_img')) {
            $vehicle->engine_img = $engine_imgStore;
        }
        if ($request->hasFile('opt_img1')) {
            $vehicle->opt_img1 = $opt_img1Store;
        }
        if ($request->hasFile('opt_img2')) {
            $vehicle->opt_img2 = $opt_img2Store;
        }
        if ($request->hasFile('opt_img3')) {
            $vehicle->opt_img3 = $opt_img3Store;
        }

        $vehicle->update();

        /* if ($request->hasFile('images'))
         {
             $photos = $request->file('images');
             $i = 1;
            foreach ($photos as $image) {
                $name = time().'-'.$image->getClientOriginalName();
                $name = str_replace('','-',$name);
                $image->storeAs('public/photos', $name);
               #$vehicle_photo->photo = $name;
               #$vehicle_photo->vehicle_id = $vehicle->id;
               #$vehicle_photo->save();
               $vehicle->vehiclephotos()->update(['photo' => $name,'photo_postion' => $i++]);
             }
           }  */

        return redirect()->route('user.edit_vehiclesale', [$listing->id, $vehicle->id])->with('success', 'Updated');

    }
    public function delete_vehiclesale($listing, $vehicle)
    {

        $vehicle = Vehicle::find($vehicle);
        $listing = Listing::find($listing);

        Storage::delete(
            'public/photos/' . $vehicle->front_img,
            'public/photos/' . $vehicle->back_img,
            'public/photos/' . $vehicle->right_img,
            'public/photos/' . $vehicle->left_img,
            'public/photos/' . $vehicle->interiorf_img,
            'public/photos/' . $vehicle->interiorb_img,
            'public/photos/' . $vehicle->engine_img,
            'public/photos/' . $vehicle->opt_img1,
            'public/photos/' . $vehicle->opt_img2,
            'public/photos/' . $vehicle->opt_img3
        );

        /* $vehicle_photos = Vehicle_photo::where('vehicle_id', $vehicle->id)->get();
         foreach ($vehicle_photos as $vehicle_photo){
                 Storage::delete('public/photos/'.$vehicle_photo->photo);
                 $vehicle_photo->delete();
         } */

        $vehicle->delete();
        $listing->delete();
        return redirect()->route('user.index_vehiclesale')->with('success', 'Removed successfully');
    }

    /* This where Carehire Logic is handled */
    public function index_carhire()
    {
        $arr['listings'] = Listing::where('user_id', Auth::id())->where('category_id', 4)->get();
        $arr['vehicles'] = Vehicle::all();
        return view('user.index_carhire')->with($arr);
    }

    public function create_carhire()
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['packages'] = Package::where('package_featured', null)->orderBy('id', 'desc')->get();
        return view('user.create_carhire')->with($arr);
    }

    public function store_carhire(Request $request, Listing $listing, Vehicle $vehicle)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'city_id' => 'required',
            'model_id' => 'required',
            'year_of_build' => 'required',
            'condition' => 'required',
            'mileage' => 'required',
            'transmission' => 'required',
            'fuel_type' => 'required',
            'exchange' => 'required',
            'description' => 'required',
            'body_type' => 'required',
            'package_id' => 'required',
            'vehicle_type' => 'required',
            'color' => 'required',
            'front_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'back_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'right_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'left_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'interiorf_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'interiorb_img' => 'required|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'opt_img1' => '|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'opt_img2' => '|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'opt_img3' => '|image|max:20480|mimes:jpeg,png,jpg,gif,svg,heic',
            'pickup_date' => 'nullable|required|date',
            'return_date' => 'nullable|required|date|after:pickup_date',
        ]);

        $listing->fill($request->only([
            'category_id',
            'city_id',
            'package_id',
            'user_id',
            'ads_status'
        ]))->save();

        $currentId = $listing->id;

        $imageFields = ['front_img', 'back_img', 'right_img', 'left_img', 'interiorf_img', 'interiorb_img', 'opt_img1', 'opt_img2', 'opt_img3'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $image = $request->file($field);
                $imageName = $field . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/photos', $imageName);
                $vehicle->{$field} = $imageName;
            }
        }

        $vehicle->fill($request->only([
            'model_id',
            'year_of_build',
            'condition',
            'mileage',
            'transmission',
            'fuel_type',
            'exchange',
            'description',
            'body_type',
            'interior_type',
            'engine_size',
            'vehicle_type',
            'color',
            'rent_days',
            'price_per_day',
            'pickup_date',
            'return_date'
        ]));

        $vehicle->listing_id = $currentId;
        $vehicle->save();

        return redirect()->route('user.invoice', [$listing->id, $vehicle->id])->with('success', 'Added');
    }


    public function edit_carhire(Listing $listing, Vehicle $vehicle)
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['listing'] = $listing;
        $arr['packages'] = Package::all();
        $arr['vehicle'] = $vehicle;

        return view('user.edit_carhire')->with($arr);
    }

    public function update_carhire(Request $request, Listing $listing, Vehicle $vehicle)
    {


        $listing->city_id = $request->city;
        $listing->update();

        $currentId = $listing->id;


        //Handle File Upload
        if ($request->hasFile('front_img')) {
            $imagenamewithExt = $request->file('front_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('front_img')->getClientOriginalExtension();
            $front_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('front_img')->storeAs('public/photos', $front_imgStore);
        }

        if ($request->hasFile('back_img')) {
            $imagenamewithExt = $request->file('back_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('back_img')->getClientOriginalExtension();
            $back_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('back_img')->storeAs('public/photos', $back_imgStore);
        }

        if ($request->hasFile('right_img')) {
            $imagenamewithExt = $request->file('right_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('right_img')->getClientOriginalExtension();
            $right_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('right_img')->storeAs('public/photos', $right_imgStore);
        }

        if ($request->hasFile('left_img')) {
            $imagenamewithExt = $request->file('left_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('left_img')->getClientOriginalExtension();
            $left_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('left_img')->storeAs('public/photos', $left_imgStore);
        }

        if ($request->hasFile('interiorf_img')) {
            $imagenamewithExt = $request->file('interiorf_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('interiorf_img')->getClientOriginalExtension();
            $interiorf_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('interiorf_img')->storeAs('public/photos', $interiorf_imgStore);
        }
        //interior back image upload code
        if ($request->hasFile('interiorb_img')) {
            $imagenamewithExt = $request->file('interiorb_img')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('interiorb_img')->getClientOriginalExtension();
            $interiorb_imgStore = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('interiorb_img')->storeAs('public/photos', $interiorb_imgStore);
        }

        if ($request->hasFile('opt_img1')) {
            $imagenamewithExt = $request->file('opt_img1')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('opt_img1')->getClientOriginalExtension();
            $opt_img1Store = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('opt_img1')->storeAs('public/photos', $opt_img1Store);
        } else {
            $opt_img1Store = '';
        }

        if ($request->hasFile('opt_img2')) {
            $imagenamewithExt = $request->file('opt_img2')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('opt_img2')->getClientOriginalExtension();
            $opt_img2Store = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('opt_img2')->storeAs('public/photos', $opt_img2Store);
        } else {
            $opt_img2Store = '';
        }

        if ($request->hasFile('opt_img3')) {
            $imagenamewithExt = $request->file('opt_img3')->getClientOriginalName();
            $imagename = pathinfo($imagenamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('opt_img3')->getClientOriginalExtension();
            $opt_img3Store = $imagename . '_' . time() . '.' . $extension;
            $path = $request->file('opt_img3')->storeAs('public/photos', $opt_img3Store);
        } else {
            $opt_img3Store = '';
        }

        $vehicle->listing_id = $currentId;
        $vehicle->model_id = $request->model_id;
        $vehicle->year_of_build = $request->year_of_build;
        $vehicle->condition = $request->condition;
        $vehicle->mileage = $request->mileage;
        $vehicle->transmission = $request->transmission;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->exchange = $request->exchange;
        $vehicle->description = $request->description;
        $vehicle->body_type = $request->body_type;
        $vehicle->interior_type = $request->interior_type;
        $vehicle->engine_size = $request->engine_size;
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->color = $request->color;
        $vehicle->rent_days = $request->rent_days;
        $vehicle->price_per_day = $request->price_per_day;
        $vehicle->pickup_date = $request->pickup_date;
        $vehicle->return_date = $request->return_date;


        if ($request->hasFile('front_img')) {
            $vehicle->front_img = $front_imgStore;
        }
        if ($request->hasFile('back_img')) {
            $vehicle->back_img = $back_imgStore;
        }
        if ($request->hasFile('right_img')) {
            $vehicle->right_img = $right_imgStore;
        }
        if ($request->hasFile('left_img')) {
            $vehicle->left_img = $left_imgStore;
        }
        if ($request->hasFile('interiorf_img')) {
            $vehicle->interiorf_img = $interiorf_imgStore;
        }
        if ($request->hasFile('interiorb_img')) {
            $vehicle->interiorb_img = $interiorb_imgStore;
        }
        if ($request->hasFile('opt_img1')) {
            $vehicle->opt_img1 = $opt_img1Store;
        }
        if ($request->hasFile('opt_img2')) {
            $vehicle->opt_img2 = $opt_img2Store;
        }
        if ($request->hasFile('opt_img3')) {
            $vehicle->opt_img3 = $opt_img3Store;
        }

        $vehicle->update();

        return redirect()->route('user.edit_carhire', [$listing->id, $vehicle->id])->with('success', 'Updated');
    }

    public function show_carhire(Listing $listing, Vehicle $vehicle)
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['listing'] = $listing;
        $arr['vehicle'] = $vehicle;
        $arr['vehiclephotos'] = Vehicle_photo::all();

        return view('user.show_carhire')->with($arr);
    }

    // public function delete_carhire($listing, $vehicle)
    // {

    //     $vehicle = Vehicle::find($vehicle);
    //     $listing = Listing::find($listing);

    //     Storage::delete(
    //         'public/photos/' . $vehicle->front_img,
    //         'public/photos/' . $vehicle->back_img,
    //         'public/photos/' . $vehicle->right_img,
    //         'public/photos/' . $vehicle->left_img,
    //         'public/photos/' . $vehicle->interiorf_img,
    //         'public/photos/' . $vehicle->interiorb_img,
    //         'public/photos/' . $vehicle->opt_img1,
    //         'public/photos/' . $vehicle->opt_img2,
    //         'public/photos/' . $vehicle->opt_img3
    //     );

    //     $vehicle->delete();
    //     $listing->delete();
    //     return redirect()->route('user.index_carhire')->with('success', 'removed successfully');
    // }

    public function invoice(Listing $listing, Vehicle $vehicle)
    {
        $arr['categories'] = Category::all();
        $arr['cities'] = City::all();
        $arr['makes'] = Carmake::all();
        $arr['models'] = Carmodel::all();
        $arr['listing'] = $listing;
        $arr['vehicle'] = $vehicle;
        $arr['packages'] = Package::all();

        return view('user.invoice')->with($arr);
    }

    public function packages(Request $request, listing $listing)
    {
        $arr['packages'] = Package::all();
        $arr['listing'] = $listing;


        return view('user.packages')->with($arr);

    }

    public function packageupdate(Request $request, $listing)
    {
        $current = Carbon::now();
        // add 3 days to the current time
        $package_id = $request->input('package_id');
        $package_duration = $current->addDays($request->input('package_duration'))->format('Y-m-d');

        DB::update('update listings set package_id = ?, ads_duration = ? where id = ?', [$package_id, $package_duration, $listing]);
        echo "Record updated successfully.
        ";
        return redirect()->route('user.checkout', ['listing_id' => $listing, 'package_id' => $package_id]);
    }

    public function checkout(Request $request)
    {
        $listingid = $request->listing_id;
        $packageid = $request->package_id;
        $arr['packages'] = Package::all();
        $arr['listing'] = $listingid;
        $arr['packageid'] = $packageid;


        return view('user.checkout')->with($arr);

    }

    public function post_invoice(Request $request, Invoice $invoice, Listing $listing)
    {


        $current = Carbon::now();
        // add 3 days to the current time
        $InvoiceExpires = $current->addDays(3);

        $invoice->user_id = $request->user_id;
        $invoice->bill_to = auth::user()->name;
        $invoice->generate_date = Carbon::now()->format('Y-m-d');
        $invoice->due_date = $InvoiceExpires;
        $invoice->package_id = $request->package_id;
        $invoice->listing_id = $request->listing_id;
        $invoice->status = 'UNPAID';
        $invoice->total = $request->total;


        $invoice->save();



        return redirect()->route('user.invoice.show', $invoice->id)->with('success', 'Added');


        /*
            $invoice->bill_to
            $invoice->generate_date
            $invoice->due_date
            $invoice->subtotal
            $invoice->tax
            $invoice->total
            $invoice->bill_to

            */
    }


    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function exportpackage()
    {
        return Excel::download(new PackagesExport, 'packages.xlsx');
    }


}
