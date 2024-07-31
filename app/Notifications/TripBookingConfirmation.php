<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Trip;

class TripBookingConfirmation extends Notification implements ShouldQueue

{
    use Queueable;

    protected $trip;

    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your trip booking has been confirmed.')
                    ->line('Trip details:')
                    ->line('From: ' . $this->trip->starting_point)
                    ->line('To: ' . $this->trip->ending_point)
                    ->line('Date: ' . $this->trip->starting_at->format('Y-m-d H:i'))
                    ->line('Price: $' . $this->trip->price)
                    ->action('View Trip', url('/trips/' . $this->trip->id))
                    ->line('Thank you for using our application!');
    }
}