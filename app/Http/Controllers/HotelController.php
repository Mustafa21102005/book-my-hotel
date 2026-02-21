<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesMedia;
use App\Http\Requests\HotelFilterRequest;
use App\Models\Hotel;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    use HandlesMedia;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::all();

        return view('hotels.index', compact('hotels'));
    }

    /**
     * Display all hotels for customers.
     */
    public function customer(HotelFilterRequest $request)
    {
        $filters = $request->validated();

        $query = Hotel::query()
            ->with('media')
            ->withAvg('reviews as rating_avg', 'rating')
            ->when($filters['region'] ?? null, fn($q, $v) => $q->where('region', $v))
            ->when($filters['country'] ?? null, fn($q, $v) => $q->where('country', $v))
            ->when($filters['city'] ?? null, fn($q, $v) => $q->where('city', $v))
            ->when($filters['rating'] ?? null, fn($q, $v) => $q->having('rating_avg', '>=', $v));

        foreach (['wifi', 'pool', 'breakfast', 'gym', 'pets_allowed', 'environment'] as $column) {
            if (!empty($filters[$column])) {
                $query->where($column, true);
            }
        }

        $hotels = $query->paginate(6)->withQueryString();

        return view('hotels.customer.index', compact('hotels'));
    }

    /**
     * Get the hotels of the manager.
     *
     * @return \Illuminate\View
     */
    public function manager()
    {
        $manager = auth()->user();
        $manager->load('hotel');

        $hotels = $manager->hotel ? collect([$manager->hotel]) : collect();

        return view('hotels.manager.index', compact('manager', 'hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Hotel::class); // Will throw 403 if manager already has a hotel

        return view('hotels.manager.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        $this->authorize('create', Hotel::class);

        $data = $request->validated();
        $data['manager_id'] = $request->user()->id;

        $hotel = Hotel::create($data);

        // Handle uploaded files
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $hotel->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('hotel-img');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        return redirect()->route('manager.hotels.index')->with('success', 'Hotel created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        $media = $hotel->getMedia('hotel-img')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => $media->getFullUrl()
            ];
        });

        return view('hotels.show', compact('hotel', 'media'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        $files = $hotel->getMedia('hotel-img')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => $media->getFullUrl(),
                'size' => $media->size
            ];
        });

        return view('hotels.edit', compact('hotel', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        $data = $request->validated();

        $hotel->update($data);

        // Handle new uploads (if any)
        if ($request->filled('uploaded_files')) {
            $uploadedFiles = json_decode($request->uploaded_files, true);

            foreach ($uploadedFiles as $fileData) {
                $tmpPath = 'uploads/tmp/' . $fileData['folder'] . '/' . $fileData['file'];

                if (Storage::disk('public')->exists($tmpPath)) {
                    $hotel->addMedia(Storage::disk('public')->path($tmpPath))
                        ->usingFileName($fileData['file'])
                        ->toMediaCollection('hotel-img');

                    Storage::disk('public')->deleteDirectory('uploads/tmp/' . $fileData['folder']);
                }
            }
        }

        return redirect()->route(
            auth()->user()->hasRole('admin') ? 'hotels.index' : 'manager.hotels.index'
        )->with('success', 'Hotel updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->clearMediaCollection('hotel-img');

        $hotel->delete();

        return redirect()->back()->with('success', 'Hotel deleted successfully!');
    }
}
