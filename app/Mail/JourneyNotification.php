<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JourneyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $heading;
    public string $messageLine;
    public ?string $ctaText;
    public ?string $ctaUrl;
    public array $details;

    public function __construct(
        public string $subjectLine,
        string $heading,
        string $messageLine,
        ?string $ctaText = null,
        ?string $ctaUrl = null,
        array $details = []
    ) {
        $this->heading = $heading;
        $this->messageLine = $messageLine;
        $this->ctaText = $ctaText;
        $this->ctaUrl = $ctaUrl;
        $this->details = $details;
    }

    public function build(): self
    {
        return $this->subject($this->subjectLine)
            ->view('email.journey-notification');
    }
}

