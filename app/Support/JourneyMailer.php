<?php

namespace App\Support;

use App\Mail\JourneyNotification;
use App\Models\Carevent;
use App\Models\Invoice;
use App\Models\Listing;
use App\Models\SparePart;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class JourneyMailer
{
    public static function sendPasswordResetRequested(User $user): void
    {
        static::sendToUser(
            $user,
            'Password reset requested',
            'Reset link sent',
            'We received a password reset request for your account. If this was not you, ignore this email and secure your account.',
            'Login',
            route('user.login')
        );
    }

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

    public static function sendCareventSubmitted(Carevent $carevent): void
    {
        if (!$carevent->user) {
            return;
        }

        static::sendToUser(
            $carevent->user,
            'Event submitted',
            'Event listing received',
            'Your event has been submitted successfully and is now live on the events page.',
            'View Events',
            route('event'),
            [
                'Event ID' => (string) $carevent->id,
                'Title' => (string) $carevent->event_title,
                'Date' => (string) $carevent->event_date,
                'Time' => (string) $carevent->event_time,
            ]
        );
    }

    public static function sendListingStatusUpdated(Listing $listing, ?string $oldStatus = null, ?string $reason = null): void
    {
        $user = $listing->user;
        if (!$user) {
            return;
        }

        $status = strtoupper((string) $listing->ads_status);
        $vehicle = $listing->vehicles()->first();
        $ctaUrl = route('user.my_list');

        if ($vehicle) {
            $ctaUrl = (int) $listing->category_id === 4
                ? route('user.show_carhire', [$listing->id, $vehicle->id])
                : route('user.show_vehiclesale', [$listing->id, $vehicle->id]);
        }

        $message = 'Your listing status is now ' . $status . '.';
        if (!empty($reason)) {
            $message .= ' Admin note: ' . $reason;
        }

        $details = [
            'Listing ID' => (string) $listing->id,
            'Previous Status' => $oldStatus ?: '-',
            'Current Status' => $status,
        ];
        if (!empty($reason)) {
            $details['Admin Note'] = $reason;
        }

        static::sendToUser(
            $user,
            'Listing status updated',
            'Listing status changed',
            $message,
            'View Listing',
            $ctaUrl,
            $details
        );
    }

    public static function sendListingEdited(Listing $listing, Vehicle $vehicle, string $listingType = 'vehicle'): void
    {
        $user = $listing->user;
        if (!$user) {
            return;
        }

        $isCarHire = mb_strtolower($listingType) === 'car hire';
        $ctaUrl = $isCarHire
            ? route('user.show_carhire', [$listing->id, $vehicle->id])
            : route('user.show_vehiclesale', [$listing->id, $vehicle->id]);

        static::sendToUser(
            $user,
            'Listing updated',
            'Your listing was updated',
            'Your listing details and/or photos were updated successfully.',
            'View Listing',
            $ctaUrl,
            [
                'Listing ID' => (string) $listing->id,
                'Type' => $isCarHire ? 'Car Hire' : 'Vehicle Sale',
                'Status' => (string) $listing->ads_status,
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

    public static function sendInvoiceDueReminder(Invoice $invoice): void
    {
        $user = $invoice->user;
        if (!$user) {
            return;
        }

        static::sendToUser(
            $user,
            'Invoice due reminder',
            'Invoice due soon',
            'Your invoice is due soon. Please complete payment to avoid service interruption.',
            'View Invoice',
            route('user.invoice.show', $invoice->id),
            [
                'Invoice ID' => (string) $invoice->id,
                'Due Date' => (string) $invoice->due_date,
                'Status' => strtoupper((string) $invoice->status),
                'Total' => 'Ksh ' . number_format((float) $invoice->total, 2),
            ]
        );
    }

    public static function sendListingExpiringSoon(Listing $listing, int $daysLeft): void
    {
        $user = $listing->user;
        if (!$user) {
            return;
        }

        $vehicle = $listing->vehicles()->first();
        $ctaUrl = route('user.my_list');
        if ($vehicle) {
            $ctaUrl = (int) $listing->category_id === 4
                ? route('user.show_carhire', [$listing->id, $vehicle->id])
                : route('user.show_vehiclesale', [$listing->id, $vehicle->id]);
        }

        static::sendToUser(
            $user,
            'Listing expiry reminder',
            'Listing expiring soon',
            'Your listing will expire in ' . $daysLeft . ' day(s). Renew it to keep it visible.',
            'Manage Listings',
            route('user.my_list'),
            [
                'Listing ID' => (string) $listing->id,
                'Expires On' => (string) $listing->ads_duration,
                'Status' => (string) $listing->ads_status,
                'View URL' => $ctaUrl,
            ]
        );
    }

    public static function sendProfileUpdated(User $user, array $changes): void
    {
        if (empty($changes)) {
            return;
        }

        static::sendToUser(
            $user,
            'Profile updated',
            'Your profile was changed',
            'Your account profile details were updated. If this was not you, contact support immediately.',
            'View Profile',
            route('user.user_profile', $user->id),
            $changes
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
