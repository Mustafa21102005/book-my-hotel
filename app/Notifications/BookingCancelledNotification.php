<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Booking $booking)
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
            ->subject('Booking Cancelled')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The following booking has been cancelled:')
            ->line('Room: ' . $this->booking->room->name)
            ->line('Check-in: ' . $this->booking->check_in->format('Y-m-d'))
            ->line('Check-out: ' . $this->booking->check_out->format('Y-m-d'))
            ->line('Total Paid: AED ' . $this->booking->total_price)
            ->line('Customer: ' . $this->booking->user->name . ' (' . $this->booking->user->email . ')')
            ->line('Please process the refund below if applicable.')
            ->action('Refund Payment', route('manager.bookings.index', ['refund' => $this->booking->id]))
            ->salutation('Thank you.');
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
