<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Notifications\StayCompleted;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CompleteBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark past bookings as completed and send review emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Get all active bookings where check_out < today
        $bookings = Booking::where('booking_status', 'active')
            ->where('check_out', '<', $today)
            ->get();


        foreach ($bookings as $booking) {
            $booking->update(['booking_status' => 'completed']);

            $booking->user->notify(new StayCompleted($booking));

            $this->info('Completed booking #' . $booking->id);
        }

        $this->info('Booking completion check finished.');
    }
}
