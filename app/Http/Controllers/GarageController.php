<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageController extends Controller
{
    public function index()
    {
        $garages = Garage::all();

        return view('pages.garages', compact('garages'));
    }

    public function create_garage()
    {

        $garage = Garage::where('user_id', Auth::id())->get();
        return view('user.create_garage', compact('garage'));


    }

    public function store_garage(Request $request)
    {
        $request->validate([
            'garage_title' => 'required',
            'garage_location' => 'required',
            'garage_description' => 'required',
            'front_img' => 'required|image|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff', // Example rules; customize as needed
            'back_img' => 'image|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'right_img' => 'image|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',

        ]);
        $garage = new Garage();

        $garage->garage_title = $request->input('garage_title');
        $garage->garage_location = $request->input('garage_location');
        $garage->garage_description = $request->input('garage_description');
        $garage->front_img = $request->file('front_img')->store('garages');
        $garage->back_img = $request->file('back_img')->store('garages');
        $garage->right_img = $request->file('right_img')->store('garages');
        $garage->left_img = $request->file('left_img');
        $garage->interiorf_img = $request->file('interiorf_img');
        $garage->interiorb_img = $request->file('interiorb_img');
        $garage->opt_img1 = $request->file('opt_img1');
        $garage->opt_img2 = $request->file('opt_img2');
        $garage->opt_img3 = $request->file('opt_img3');
        $garage->user_id = auth()->user()->id;



        $garage->save();

        return redirect()->route('garages.index');
    }

    public function show(Garage $garage)
    {
        return view('garages.show', compact('garage'));
    }
}