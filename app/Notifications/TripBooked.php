<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Trip;
use App\Models\User;

class TripBooked extends Notification implements ShouldQueue

{
    use Queueable;

    protected $trip;
    protected $booker;

    public function __construct(Trip $trip, User $booker)
    {
        $this->trip = $trip;
        $this->booker = $booker;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A seat has been booked on your trip.')
                    ->line('Trip details:')
                    ->line('From: ' . $this->trip->starting_point)
                    ->line('To: ' . $this->trip->ending_point)
                    ->line('Date: ' . $this->trip->starting_at->format('Y-m-d H:i'))
                    ->line('Booked by: ' . $this->booker->firstname . ' ' . $this->booker->lastname)
                    ->action('View Trip', url('/trips/' . $this->trip->id))
                    ->line('Thank you for using our application!');
    }
}