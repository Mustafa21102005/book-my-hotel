<?php

namespace App\Notifications;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Booking is Confirmed!')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your booking has been successfully confirmed.')
            ->line('Hotel: ' . $this->booking->room->hotel->name)
            ->line('Room: ' . $this->booking->room->name)
            ->line('Check-in: ' . Carbon::parse($this->booking->check_in)->format('M d, Y'))
            ->line('Check-out: ' . Carbon::parse($this->booking->check_out)->format('M d, Y'))
            ->line('Total: AED ' . number_format($this->booking->total_price, 2))
            ->when($this->booking->room->hotel->environment, function ($mail) {
                $mail->line('🌿 You earned 20 sustainability points for booking an eco-friendly hotel!');
            })
            ->line('Thank you for choosing Book-My-Hotel!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
