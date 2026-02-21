<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesMedia;
use App\Http\Requests\RoomFilterRequest;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    use HandlesMedia;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Get the rooms of the hotel or all rooms.
     *
     * @param null|int $hotel The id of the hotel.
     * @return \Illuminate\View\View
     */
    public function customer(RoomFilterRequest $request, ?Hotel $hotel = null)
    {
        $filters = $request->validated();

        $query = Room::query()
            ->with(['media', 'hotel'])
            ->when($hotel, fn($q) => $q->whereBelongsTo($hotel))
            ->when(
                $filters['price_min'] ?? null,
                fn($q, $v) => $q->where('price', '>=', $v)
            )
            ->when(
                $filters['price_max'] ?? null,
                fn($q, $v) => $q->where('price', '<=', $v)
            )
            ->when(
                $filters['type'] ?? null,
                fn($q, $v) => $q->where('type', $v)
            )
            ->where('capacity', '>=', $filters['adults'] ?? 1)
            ->when($filters['promotion_only'] ?? false, function ($q) {
                $q->whereHas('hotel.promotions', function ($p) {
                    $p->where('is_active', true);
                });
            });

        $rooms = $query->paginate(6)->withQueryString();

        return view('rooms.customer.index', [
            'rooms'         => $rooms,
            'hotelData'     => $hotel,
            'adults'        => $filters['adults'] ?? 1,
            'priceMin'      => $filters['price_min'] ?? null,
            'priceMax'      => $filters['price_max'] ?? null,
            'promotionOnly' => $filters['promotion_only'] ?? false,
            'roomType'      => $filters['type'] ?? null,
        ]);
    }

    /**
     * Get the rooms of the manager.
     *
     * @return \Illuminate\View\View
     */
    public function manager()
    {
        $manager = auth()->user();

        $rooms = $manager->hotel->rooms()->get();

        return view('rooms.manager.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rooms.manager.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $data = $request->validated();
        $data['hotel_id'] = auth()->user()->hotel->id;

        $room = Room::create($data);

        // Handle uploaded files
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $room->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('room-img');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        return redirect()->route('manager.rooms.index')->with('success', 'Room created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $media = $room->getMedia('room-img')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => $media->getFullUrl()
            ];
        });

        return view('rooms.show', compact('room', 'media'));
    }

    /**
     * Display the specified resource for the customer.
     *
     * @param \App\Models\Room $room
     * @return \Illuminate\View\View
     */
    public function customerShow(Room $room)
    {
        $room->load(['media', 'hotel']);

        $bookedDates = $room->bookings()
            ->where('booking_status', 'active')
            ->get(['check_in', 'check_out'])
            ->map(fn($b) => [
                'start' => $b->check_in->format('Y-m-d'),
                'end'   => $b->check_out->format('Y-m-d'),
            ])
            ->toArray();

        // Base review query
        $reviewQuery = $room->hotel->reviews()->with('user');

        // Paginated reviews (1 query)
        $reviews = $reviewQuery->latest()->paginate(4);

        // Aggregated stats (1 query only)
        $stats = $room->hotel->reviews()
            ->selectRaw("
            COUNT(*) as total,
            ROUND(AVG(rating), 2) as avg_rating,
            SUM(CASE WHEN rating IN (4,5) THEN 1 ELSE 0 END) as positive,
            SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as neutral,
            SUM(CASE WHEN rating IN (1,2) THEN 1 ELSE 0 END) as negative
        ")
            ->first();

        $reviewsCount  = $stats->total ?? 0;
        $averageRating = $stats->avg_rating ?? 0;

        if ($reviewsCount > 0) {
            $positivePercent = round(($stats->positive / $reviewsCount) * 100);
            $neutralPercent  = round(($stats->neutral / $reviewsCount) * 100);
            $negativePercent = round(($stats->negative / $reviewsCount) * 100);
        } else {
            $positivePercent = $neutralPercent = $negativePercent = 0;
        }

        if (request()->ajax()) {
            return view('rooms.partials.reviews', compact('reviews'))->render();
        }

        return view('rooms.customer.show', compact(
            'room',
            'reviews',
            'reviewsCount',
            'averageRating',
            'positivePercent',
            'neutralPercent',
            'negativePercent',
            'bookedDates'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $files = $room->getMedia('room-img')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => $media->getFullUrl(),
                'size' => $media->size
            ];
        });

        return view('rooms.edit', compact('room', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $data = $request->validated();

        $room->update($data);

        // Handle new uploads (if any)
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $room->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('room-img');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        return redirect()->route(
            auth()->user()->hasRole('admin') ? 'rooms.index' : 'manager.rooms.index'
        )->with('success', 'Hotel updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->clearMediaCollection('room-img');

        $room->delete();

        return redirect()->back()->with('success', 'Room deleted successfully!');
    }
}
