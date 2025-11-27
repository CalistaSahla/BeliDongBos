<?php

namespace App\Mail;

use App\Models\Rating;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RatingThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Rating $rating, public Product $product)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima Kasih atas Ulasan Anda - BeliDongBos',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rating-thank-you',
        );
    }
}
