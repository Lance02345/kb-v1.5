<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillFreeBillingForExistingNonVehicleListings extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('packages') || !Schema::hasTable('listings') || !Schema::hasTable('invoices')) {
            return;
        }

        $packageId = $this->resolveFreePackageId();
        if (!$packageId) {
            return;
        }

        $this->backfillTable('spare_parts', null, $packageId);
        $this->backfillTable('garages', null, $packageId);
        $this->backfillTable('carevents', 7, $packageId);
    }

    public function down()
    {
        // No-op by design. This migration creates accounting records for existing data.
    }

    private function resolveFreePackageId(): ?int
    {
        $existing = DB::table('packages')
            ->where('package_name', 'Free Plan')
            ->orderBy('id')
            ->first();

        if ($existing) {
            return (int) $existing->id;
        }

        $now = Carbon::now();

        DB::table('packages')->insert([
            'package_name' => 'Free Plan',
            'package_amount' => 0,
            'package_duration' => 30,
            'package_featured' => null,
            'description' => 'Free package for non-vehicle listings.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $created = DB::table('packages')
            ->where('package_name', 'Free Plan')
            ->orderByDesc('id')
            ->first();

        return $created ? (int) $created->id : null;
    }

    private function backfillTable(string $table, ?int $categoryId, int $packageId): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $requiredColumns = ['id', 'user_id', 'listing_id', 'invoice_id'];
        foreach ($requiredColumns as $column) {
            if (!Schema::hasColumn($table, $column)) {
                return;
            }
        }

        $lastId = 0;

        while (true) {
            $rows = DB::table($table)
                ->select('id', 'user_id')
                ->where('id', '>', $lastId)
                ->whereNotNull('user_id')
                ->where(function ($query) {
                    $query->whereNull('listing_id')
                        ->orWhereNull('invoice_id');
                })
                ->orderBy('id')
                ->limit(200)
                ->get();

            if ($rows->isEmpty()) {
                break;
            }

            foreach ($rows as $row) {
                $now = Carbon::now();
                $durationDays = 30;

                $listingId = DB::table('listings')->insertGetId([
                    'ads_status' => 'Approved',
                    'ads_featured' => '0',
                    'ads_duration' => Carbon::now()->addDays($durationDays)->format('Y-m-d'),
                    'category_id' => $categoryId,
                    'city_id' => null,
                    'package_id' => $packageId,
                    'user_id' => $row->user_id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $userName = DB::table('users')->where('id', $row->user_id)->value('name');

                $invoiceId = DB::table('invoices')->insertGetId([
                    'bill_to' => $userName,
                    'generate_date' => Carbon::today()->format('Y-m-d'),
                    'due_date' => Carbon::today()->format('Y-m-d'),
                    'subtotal' => 0,
                    'tax' => 0,
                    'total' => 0,
                    'paid' => 1,
                    'status' => 'PAID',
                    'user_id' => $row->user_id,
                    'package_id' => $packageId,
                    'listing_id' => $listingId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                DB::table($table)
                    ->where('id', $row->id)
                    ->update([
                        'listing_id' => $listingId,
                        'invoice_id' => $invoiceId,
                    ]);

                $lastId = (int) $row->id;
            }
        }
    }
}
