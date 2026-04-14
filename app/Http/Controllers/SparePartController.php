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
use App\Support\ListingBilling;
use App\Support\OptimizedImageStore;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class SparePartController extends Controller
{
    public function __construct(private OptimizedImageStore $optimizedImageStore)
    {
    }

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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'price' => 'required|numeric',
            // Add validation rules for the photo uploads
            'front_img' => 'required|file|max:2048|mimetypes:image/*',
            'back_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'right_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'left_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'interiorf_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'interiorb_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'opt_img1' => 'nullable|file|max:2048|mimetypes:image/*',
            'opt_img2' => 'nullable|file|max:2048|mimetypes:image/*',
            'opt_img3' => 'nullable|file|max:2048|mimetypes:image/*',
        ]);

        $sparePart = DB::transaction(function () use ($request) {
            $sparePart = new SparePart([
                'category' => $request->category,
                'make' => $request->make,
                'item_name' => $request->item_name,
                'item_description' => $request->item_description,
                'condition' => $request->condition,
                'location' => $request->location,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'price' => $request->price,
                'user_id' => auth()->id(),
            ]);

            foreach (self::IMAGE_FIELDS as $fieldName) {
                if ($request->hasFile($fieldName)) {
                    $sparePart->$fieldName = $this->storeProcessedSparePartImage($request->file($fieldName), $fieldName);
                }
            }

            $sparePart->save();

            $billing = ListingBilling::createFreeForUser((int) auth()->id());
            $sparePart->listing_id = $billing['listing']->id;
            $sparePart->invoice_id = $billing['invoice']->id;
            $sparePart->save();

            $billing['invoice']->load('user', 'package');
            JourneyMailer::sendInvoiceGenerated($billing['invoice']);

            return $sparePart;
        });

        $sparePart->load('user');
        JourneyMailer::sendSparePartSubmitted($sparePart);

        return redirect()->route('user.myspareparts')->with('success', 'Spare part added successfully. Free package + invoice applied.');


    }

    public function myspareparts(SparePart $spareParts, Listing $listing)
    {
        $spareParts = SparePart::with(['listing.package', 'invoice'])->where('user_id', Auth::id())->latest('id')->get();
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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'price' => 'required|numeric',
            'front_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'back_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'right_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'left_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'interiorf_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'interiorb_img' => 'nullable|file|max:2048|mimetypes:image/*',
            'opt_img1' => 'nullable|file|max:2048|mimetypes:image/*',
            'opt_img2' => 'nullable|file|max:2048|mimetypes:image/*',
            'opt_img3' => 'nullable|file|max:2048|mimetypes:image/*',
        ]);

        $sparePart->category = $request->category;
        $sparePart->make = $request->make;
        $sparePart->item_name = $request->item_name;
        $sparePart->item_description = $request->item_description;
        $sparePart->condition = $request->condition;
        $sparePart->location = $request->location;
        $sparePart->price = $request->price;
        $sparePart->latitude = $request->input('latitude');
        $sparePart->longitude = $request->input('longitude');

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
            ->with('user')
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
        $similarParts = SparePart::query()
            ->with('user')
            ->where('id', '!=', $sparePart->id)
            ->when($sparePart->make || $sparePart->category, function ($query) use ($sparePart) {
                $query->where(function ($inner) use ($sparePart) {
                    $started = false;
                    if (!empty($sparePart->make)) {
                        $inner->where('make', $sparePart->make);
                        $started = true;
                    }
                    if (!empty($sparePart->category)) {
                        if ($started) {
                            $inner->orWhere('category', $sparePart->category);
                        } else {
                            $inner->where('category', $sparePart->category);
                        }
                    }
                });
            })
            ->latest('id')
            ->take(4)
            ->get();

        return view('modern.sparepart', compact('sparePart', 'userWhoPosted', 'similarParts'));

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

        $spareParts = $query->with('user')->latest('id')->paginate(12)->withQueryString();
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
        return basename($this->optimizedImageStore->storePublicImage(
            $image,
            'photos',
            $fieldPrefix,
            public_path('watermark/KINGSBRIDGE.png')
        ));
    }

}
