<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Listing;
use App\Support\JourneyMailer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendJourneyReminders extends Command
{
    protected $signature = 'journey:send-reminders';

    protected $description = 'Send invoice due and listing expiry reminder emails';

    public function handle(): int
    {
        $now = Carbon::now();
        $invoiceDueDate = $now->copy()->addDay()->toDateString();
        $listingExpiryDate = $now->copy()->addDays(3)->toDateString();

        $invoices = Invoice::query()
            ->with('user')
            ->whereDate('due_date', $invoiceDueDate)
            ->whereNotIn('status', ['PAID', 'Paid', 'paid'])
            ->get();

        foreach ($invoices as $invoice) {
            JourneyMailer::sendInvoiceDueReminder($invoice);
        }

        $listings = Listing::query()
            ->with('user')
            ->whereIn('ads_status', ['Approved', 'Active'])
            ->whereDate('ads_duration', $listingExpiryDate)
            ->get();

        foreach ($listings as $listing) {
            JourneyMailer::sendListingExpiringSoon($listing, 3);
        }

        $this->info('Invoice reminders sent: ' . $invoices->count());
        $this->info('Listing expiry reminders sent: ' . $listings->count());

        return self::SUCCESS;
    }
}

