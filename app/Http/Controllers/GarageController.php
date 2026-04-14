<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Support\JourneyMailer;
use App\Support\ListingBilling;
use App\Support\OptimizedImageStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class GarageController extends Controller
{
    public function __construct(private OptimizedImageStore $optimizedImageStore)
    {
    }

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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
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

        DB::transaction(function () use ($request) {
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

            $garage->latitude = $request->input('latitude');
            $garage->longitude = $request->input('longitude');

            $garage->save();

            $billing = ListingBilling::createFreeForUser((int) auth()->id());
            $garage->listing_id = $billing['listing']->id;
            $garage->invoice_id = $billing['invoice']->id;
            $garage->save();

            $billing['invoice']->load('user', 'package');
            JourneyMailer::sendInvoiceGenerated($billing['invoice']);
        });

        return redirect()->route('user.mygarages')->with('success', 'Garage listing created successfully. Free package + invoice applied.');
    }

    public function mygarages()
    {
        $garages = Garage::with(['listing.package', 'invoice'])->where('user_id', Auth::id())->latest('id')->get();
        return view('user.garages_list', compact('garages'));
    }

    public function show(Garage $garage)
    {
        $garage->load('user');
        return view('modern.garage', compact('garage'));
    }

    private function storeGarageImage(UploadedFile $image, string $fieldPrefix): string
    {
        return $this->optimizedImageStore->storePublicImage($image, 'garages', $fieldPrefix);
    }
}
