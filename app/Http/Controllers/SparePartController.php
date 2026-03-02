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
use App\Support\JourneyMailer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class SparePartController extends Controller
{
    private const IMAGE_FIELDS = [
        'front_img',
        'back_img',
        'right_img',
        'left_img',
        'interiorf_img',
        'interiorb_img',
        'opt_img1',
        'opt_img2',
        'opt_img3',
    ];

    public function create()
    {
        $categories = SparePart::CATEGORIES;
        return view('user.create_spareparts', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:' . implode(',', SparePart::CATEGORIES),
            'make' => 'required',
            'item_name' => 'required',
            'item_description' => 'required',
            'condition' => 'required|in:Used,New',
            'location' => 'required',
            'price' => 'required|numeric',
            // Add validation rules for the photo uploads
            'front_img' => 'required|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff', // Example rules; customize as needed
            'back_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'right_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'left_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'interiorf_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'interiorb_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img1' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img2' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img3' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
        ]);

        // Store the spare part data and photo paths in the database
        $sparePart = new SparePart([
            'category' => $request->category,
            'make' => $request->make,
            'item_name' => $request->item_name,
            'item_description' => $request->item_description,
            'condition' => $request->condition,
            'location' => $request->location,
            'price' => $request->price,
            'user_id' => auth()->id(),
        ]);

        foreach (self::IMAGE_FIELDS as $fieldName) {
            if ($request->hasFile($fieldName)) {
                $sparePart->$fieldName = $this->storeProcessedSparePartImage($request->file($fieldName), $fieldName);
            }
        }

        $sparePart->save();

        $sparePart->load('user');
        JourneyMailer::sendSparePartSubmitted($sparePart);

        return redirect()->route('user.myspareparts')->with('success', 'Spare part added successfully.');


    }

    public function myspareparts(SparePart $spareParts, Listing $listing)
    {
        $spareParts = SparePart::where('user_id', Auth::id())->latest('id')->get();
        $vehicles = Vehicle::all();
        $listings = Listing::where('ads_status', 'Expired')->where('user_id', Auth::id())->get();
        return view('user.spareparts_list', compact('spareParts', 'listings', 'vehicles'));


    }

    public function edit(SparePart $sparePart)
    {
        abort_if((int) $sparePart->user_id !== (int) Auth::id(), 403);
        $categories = SparePart::CATEGORIES;
        return view('user.edit_spareparts', compact('sparePart', 'categories'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        abort_if((int) $sparePart->user_id !== (int) Auth::id(), 403);

        $request->validate([
            'category' => 'required|string|in:' . implode(',', SparePart::CATEGORIES),
            'make' => 'required',
            'item_name' => 'required',
            'item_description' => 'required',
            'condition' => 'required|in:Used,New',
            'location' => 'required',
            'price' => 'required|numeric',
            'front_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'back_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'right_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'left_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'interiorf_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'interiorb_img' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img1' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img2' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
            'opt_img3' => 'nullable|file|max:2048|mimes:jpeg,png,jpg,gif,svg,heif,heic,webp,bmp,tiff',
        ]);

        $sparePart->category = $request->category;
        $sparePart->make = $request->make;
        $sparePart->item_name = $request->item_name;
        $sparePart->item_description = $request->item_description;
        $sparePart->condition = $request->condition;
        $sparePart->location = $request->location;
        $sparePart->price = $request->price;

        foreach (self::IMAGE_FIELDS as $fieldName) {
            if ($request->hasFile($fieldName)) {
                if (!empty($sparePart->{$fieldName})) {
                    Storage::delete('public/photos/' . $sparePart->{$fieldName});
                }
                $sparePart->{$fieldName} = $this->storeProcessedSparePartImage($request->file($fieldName), $fieldName);
            }
        }

        $sparePart->save();

        return redirect()->route('user.myspareparts')->with('success', 'Spare part updated successfully.');
    }

    public function destroy(SparePart $sparePart)
    {
        abort_if((int) $sparePart->user_id !== (int) Auth::id(), 403);

        foreach (self::IMAGE_FIELDS as $fieldName) {
            if (!empty($sparePart->{$fieldName})) {
                Storage::delete('public/photos/' . $sparePart->{$fieldName});
            }
        }

        $sparePart->delete();

        return redirect()->route('user.myspareparts')->with('success', 'Spare part deleted successfully.');
    }

    public function showspareparts(SparePart $spareParts, Listing $listing)
    {
        $spareParts = SparePart::query()
            ->latest('id')
            ->paginate(12);

        $categories = SparePart::CATEGORIES;
        $categoryCounts = SparePart::query()
            ->selectRaw('category, COUNT(*) as total')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->orderByDesc('total')
            ->pluck('total', 'category');

        return view('modern.spareparts', compact('spareParts', 'categories', 'categoryCounts'));


    }

    public function sparepart($id)
    {
        $sparePart = SparePart::with('user')->findOrFail($id);
        $userWhoPosted = $sparePart->user;
        return view('modern.sparepart', compact('sparePart', 'userWhoPosted'));

    }

    public function spare_parts_search(Request $request)
    {
        $request->validate([
            'category' => 'nullable|string|in:' . implode(',', SparePart::CATEGORIES),
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
            $query->where('condition', ucfirst(strtolower($request->condition)));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search by minimum price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        // Search by maximum price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $spareParts = $query->latest('id')->paginate(12)->withQueryString();
        $categories = SparePart::CATEGORIES;
        $categoryCounts = SparePart::query()
            ->selectRaw('category, COUNT(*) as total')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->orderByDesc('total')
            ->pluck('total', 'category');

        return view('modern.spareparts', compact('spareParts', 'categories', 'categoryCounts'));
    }

    private function storeProcessedSparePartImage(UploadedFile $image, string $fieldPrefix): string
    {
        $extension = strtolower($image->getClientOriginalExtension() ?: 'jpg');
        $imageName = $fieldPrefix . '_' . time() . '_' . uniqid() . '.' . $extension;

        try {
            $img = Image::make($image)->orientate();
            $watermark = Image::make(public_path('watermark/KINGSBRIDGE.png'));

            $maxWatermarkWidth = max(80, (int) round($img->width() * 0.2));
            $maxWatermarkHeight = max(40, (int) round($img->height() * 0.2));
            $watermark->resize($maxWatermarkWidth, $maxWatermarkHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->insert($watermark, 'bottom-right', 16, 16);
            $img->save(public_path('storage/photos/' . $imageName));
        } catch (\Throwable $e) {
            $image->storeAs('public/photos', $imageName);
        }

        return $imageName;
    }

}
