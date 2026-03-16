<?php

namespace App\Notifications;

use App\Models\SavedSearch;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SavedSearchAlert extends Notification
{
    use Queueable;

    public function __construct(protected SavedSearch $search, protected ?Vehicle $vehicle)
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('New matches for "' . $this->search->name . '"')
            ->line('A new vehicle matches your saved search.');

        if ($this->vehicle && $this->vehicle->listing) {
            $mail->action('View listing', route('vehicle', [$this->vehicle->listing->id, $this->vehicle->id]));
        }

        return $mail;
    }

    public function toArray($notifiable)
    {
        return [
            'search_id' => $this->search->id,
            'vehicle_id' => $this->vehicle?->id,
            'message' => 'New vehicle matches "' . $this->search->name . '"',
        ];
    }
}
