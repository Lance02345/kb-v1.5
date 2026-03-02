<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;

class GarageController extends Controller
{
    public function index()
    {
        $garages = Garage::with('user')->latest('id')->paginate(12);

        return view('modern.garages', compact('garages'));
    }

    public function create_garage()
    {
        return view('user.create_garage');
    }

    public function store_garage(Request $request)
    {
        $request->validate([
            'garage_title' => 'required|string|max:255',
            'garage_location' => 'required|string|max:255',
            'garage_description' => 'required|string',
            'front_img' => 'required|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'back_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'right_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'left_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'interiorf_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'interiorb_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img1' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img2' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img3' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
        ]);

        $garage = new Garage();
        $garage->garage_title = $request->input('garage_title');
        $garage->garage_location = $request->input('garage_location');
        $garage->garage_description = $request->input('garage_description');
        $garage->user_id = auth()->id();

        foreach (['front_img', 'back_img', 'right_img', 'left_img', 'interiorf_img', 'interiorb_img', 'opt_img1', 'opt_img2', 'opt_img3'] as $fieldName) {
            if ($request->hasFile($fieldName)) {
                $garage->{$fieldName} = $this->storeGarageImage($request->file($fieldName), $fieldName);
            }
        }

        $garage->save();

        return redirect()->route('user.mygarages')->with('success', 'Garage listing created successfully.');
    }

    public function mygarages()
    {
        $garages = Garage::where('user_id', Auth::id())->latest('id')->get();
        return view('user.garages_list', compact('garages'));
    }

    public function show(Garage $garage)
    {
        $garage->load('user');
        return view('modern.garage', compact('garage'));
    }

    private function storeGarageImage(UploadedFile $image, string $fieldPrefix): string
    {
        $extension = strtolower($image->getClientOriginalExtension() ?: 'jpg');
        $imageName = $fieldPrefix . '_' . time() . '_' . uniqid() . '.' . $extension;
        $image->storeAs('garages', $imageName, 'public');
        return 'garages/' . $imageName;
    }
}
