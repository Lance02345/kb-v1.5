<?php

namespace App\Support;

use App\Mail\JourneyNotification;
use App\Models\Invoice;
use App\Models\Listing;
use App\Models\SparePart;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class JourneyMailer
{
    public static function sendWelcome(User $user): void
    {
        static::sendToUser(
            $user,
            'Welcome to Kingsbridge Motors',
            'Welcome aboard',
            'Your account is ready. You can now create listings, upload spare parts, and manage invoices.',
            'Go to Dashboard',
            route('user.my_list')
        );
    }

    public static function sendPasswordChanged(User $user): void
    {
        static::sendToUser(
            $user,
            'Your password was changed',
            'Password updated',
            'Your Kingsbridge password has been changed successfully. If this was not you, contact support immediately.',
            'Login',
            route('user.login')
        );
    }

    public static function sendVehicleListingSubmitted(Listing $listing, Vehicle $vehicle): void
    {
        $user = $listing->user;
        if (!$user) {
            return;
        }

        static::sendToUser(
            $user,
            'Vehicle listing submitted',
            'Listing received',
            'Your vehicle listing has been submitted and is now awaiting review.',
            'View Listing',
            route('user.show_vehiclesale', [$listing->id, $vehicle->id]),
            [
                'Listing ID' => (string) $listing->id,
                'Status' => (string) $listing->ads_status,
            ]
        );
    }

    public static function sendCarHireSubmitted(Listing $listing, Vehicle $vehicle): void
    {
        $user = $listing->user;
        if (!$user) {
            return;
        }

        static::sendToUser(
            $user,
            'Car hire listing submitted',
            'Car hire listing received',
            'Your car hire listing has been submitted and is pending review.',
            'View Car Hire Listing',
            route('user.show_carhire', [$listing->id, $vehicle->id]),
            [
                'Listing ID' => (string) $listing->id,
                'Status' => (string) $listing->ads_status,
            ]
        );
    }

    public static function sendSparePartSubmitted(SparePart $sparePart): void
    {
        if (!$sparePart->user) {
            return;
        }

        static::sendToUser(
            $sparePart->user,
            'Spare part submitted',
            'Spare part listing received',
            'Your spare part has been posted successfully.',
            'View Spare Part',
            route('sparepart', $sparePart->id),
            [
                'Spare Part ID' => (string) $sparePart->id,
                'Item' => (string) $sparePart->item_name,
            ]
        );
    }

    public static function sendInvoiceGenerated(Invoice $invoice): void
    {
        $user = $invoice->user;
        if (!$user) {
            return;
        }

        static::sendToUser(
            $user,
            'Invoice generated',
            'Your invoice is ready',
            'An invoice has been generated for your listing. You can view and download it from your account.',
            'View Invoice',
            route('user.invoice.show', $invoice->id),
            [
                'Invoice ID' => (string) $invoice->id,
                'Status' => (string) $invoice->status,
                'Total' => 'Ksh ' . number_format((float) $invoice->total, 2),
            ]
        );
    }

    public static function sendInvoiceStatusUpdated(Invoice $invoice, ?string $oldStatus = null): void
    {
        $user = $invoice->user;
        if (!$user) {
            return;
        }

        $status = strtoupper((string) $invoice->status);
        static::sendToUser(
            $user,
            'Invoice status updated',
            'Invoice status changed',
            'Your invoice status is now ' . $status . '.',
            'View Invoice',
            route('user.invoice.show', $invoice->id),
            [
                'Invoice ID' => (string) $invoice->id,
                'Previous Status' => $oldStatus ?: '-',
                'Current Status' => $status,
            ]
        );
    }

    private static function sendToUser(
        User $user,
        string $subject,
        string $heading,
        string $message,
        ?string $ctaText = null,
        ?string $ctaUrl = null,
        array $details = []
    ): void {
        if (empty($user->email)) {
            return;
        }

        try {
            Mail::to($user->email)->send(new JourneyNotification(
                $subject,
                $heading,
                $message,
                $ctaText,
                $ctaUrl,
                $details
            ));
        } catch (\Throwable $e) {
            Log::warning('Journey email failed', [
                'email' => $user->email,
                'subject' => $subject,
                'message' => $e->getMessage(),
            ]);
        }
    }
}

