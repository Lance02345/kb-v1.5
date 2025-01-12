<?php

namespace App\Http\Controllers;

use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Category;
use App\Models\City;
use App\Models\Invoice;
use App\Models\Listing;
use App\Models\Package;
use App\Models\SparePart;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class SparePartController extends Controller
{
    public function create()
    {
        return view('user.create_spareparts');
    }

    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required',
            'item_name' => 'required',
            'item_description' => 'required',
            'condition' => 'required|in:Used,New',
            'location' => 'required',
            'price' => 'required|numeric',
            // Add validation rules for the photo uploads
            'front_img' => 'required|image|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff', // Example rules; customize as needed
            'back_img' => 'image|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'right_img' => 'image|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
        ]);

        $photos = [];

        if ($request->hasFile('front_img')) {
            $frontImg = $request->file('front_img');
            $frontImgPath = $frontImg->store('photos', 'public'); // Customize the storage path as needed
            $photos['front_img'] = $frontImgPath;
        }

        if ($request->hasFile('back_img')) {
            $backImg = $request->file('back_img');
            $backImgPath = $backImg->store('photos', 'public'); // Customize the storage path as needed
            $photos['back_img'] = $backImgPath;
        }

        if ($request->hasFile('right_img')) {
            $rightImg = $request->file('right_img');
            $rightImgPath = $rightImg->store('photos', 'public'); // Customize the storage path as needed
            $photos['right_img'] = $rightImgPath;
        }

        // Store the spare part data and photo paths in the database
        $sparePart = new SparePart([
            'make' => $request->make,
            'item_name' => $request->item_name,
            'item_description' => $request->item_description,
            'condition' => $request->condition,
            'location' => $request->location,
            'price' => $request->price,
            'user_id' => auth()->id(),
        ]);

        $imageFields = ['front_img', 'back_img', 'right_img'];

        foreach ($imageFields as $fieldName) {
            if ($request->hasFile($fieldName)) {
                $image = $request->file($fieldName);
                $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $imageStore = $imageName . '_' . time() . '.' . $extension;

                // Open the image using Intervention/Image
                $img = Image::make($image);

                // Load the watermark image
                $watermark = Image::make(public_path('watermark/king.png'));

                // Add the watermark to the image
                $img->insert($watermark, 'bottom-right', 10, 10); // You can adjust the position and size of the watermark

                // Save the watermarked image with the user's name
                $img->save(public_path('storage/photos/' . $imageStore));

                // Assign the image store path to the corresponding model field
                $sparePart->$fieldName = $imageStore;
            }
        }

        $sparePart->save();

        return redirect()->route('user.myspareparts')->with('success', 'Spare part added successfully.');


    }

    public function myspareparts(SparePart $spareParts, Listing $listing)
    {

        $spareParts = SparePart::where('user_id', Auth::id())->get();
        $vehicles = Vehicle::all();
        $listings = Listing::where('ads_status', 'Expired')->where('user_id', Auth::id())->get();
        return view('user.spareparts_list', compact('spareParts', 'listings', 'vehicles'));


    }

    public function showspareparts(SparePart $spareParts, Listing $listing)
    {

        $spareParts = SparePart::all();
        $vehicles = Vehicle::all();
        $listings = Listing::all();
        return view('pages.spareparts', compact('spareParts', 'listings', 'vehicles'));


    }

    public function sparepart(SparePart $sparePart, Listing $listing, $id, user $user)
    {


        $sparePart = SparePart::find($id);
        $vehicles = Vehicle::all();
        $listings = Listing::all();
        $sparePart = SparePart::with('user')->find($id);
        if ($sparePart) {
            // Now you can access the user who posted the spare part
            $userWhoPosted = $sparePart->user;

            // Other logic...
        } else {
            // Handle the case where the spare part is not found
        }
        return view('pages.sparepart', compact('sparePart', 'userWhoPosted', 'listings', 'vehicles', 'user'));


    }

    public function spare_parts_search(Request $request)
    {
        $request->validate([
            'make' => 'nullable|string',
            'item_name' => 'nullable|string',
            // ... (other validation rules)
        ]);

        $query = SparePart::query();

        if ($request->has('make')) {
            $keywords = explode(' ', $request->input('make'));
            foreach ($keywords as $keyword) {
                $query->where('make', 'LIKE', '%' . $keyword . '%');
            }
        }

        if ($request->has('item_name')) {
            $keywords = explode(' ', $request->input('item_name'));
            foreach ($keywords as $keyword) {
                $query->where('item_name', 'LIKE', '%' . $keyword . '%');
            }
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Search by minimum price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        // Search by maximum price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $spareParts = $query->paginate(10);

        return view('pages.spareparts', ['spareParts' => $spareParts]);
    }

}

