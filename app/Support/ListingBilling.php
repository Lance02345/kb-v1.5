<?php

namespace App\Support;

use App\Models\Invoice;
use App\Models\Listing;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;

class ListingBilling
{
    public static function createFreeForUser(int $userId, ?int $categoryId = null, ?int $cityId = null): array
    {
        $package = self::ensureFreePackage();
        $durationDays = self::getDurationDays($package);

        $listing = Listing::create([
            'ads_status' => 'Approved',
            'ads_featured' => '0',
            'ads_duration' => Carbon::now()->addDays($durationDays)->format('Y-m-d'),
            'category_id' => $categoryId,
            'city_id' => $cityId,
            'package_id' => $package->id,
            'user_id' => $userId,
        ]);

        $invoice = self::createFreeInvoiceForListing($listing, $package, $userId);

        return [
            'package' => $package,
            'listing' => $listing,
            'invoice' => $invoice,
        ];
    }

    public static function applyFreePackageToListing(Listing $listing): array
    {
        $package = self::ensureFreePackage();
        $durationDays = self::getDurationDays($package);

        $listing->ads_status = 'Approved';
        $listing->ads_featured = '0';
        $listing->package_id = $package->id;
        $listing->ads_duration = Carbon::now()->addDays($durationDays)->format('Y-m-d');
        $listing->save();

        $invoice = self::createFreeInvoiceForListing($listing, $package, (int) $listing->user_id);

        return [
            'package' => $package,
            'listing' => $listing->refresh(),
            'invoice' => $invoice,
        ];
    }

    private static function ensureFreePackage(): Package
    {
        return Package::firstOrCreate(
            ['package_name' => 'Free Plan'],
            [
                'package_amount' => 0,
                'package_duration' => 30,
                'package_featured' => null,
                'description' => 'Free package for non-vehicle listings.',
            ]
        );
    }

    private static function getDurationDays(Package $package): int
    {
        return max(1, (int) ($package->package_duration ?: 30));
    }

    private static function createFreeInvoiceForListing(Listing $listing, Package $package, int $userId): Invoice
    {
        $user = User::find($userId);

        return Invoice::create([
            'bill_to' => $user?->name,
            'generate_date' => Carbon::today()->format('Y-m-d'),
            'due_date' => Carbon::today()->format('Y-m-d'),
            'subtotal' => 0,
            'tax' => 0,
            'total' => 0,
            'paid' => 1,
            'status' => 'PAID',
            'user_id' => $userId,
            'package_id' => $package->id,
            'listing_id' => $listing->id,
        ]);
    }
}
