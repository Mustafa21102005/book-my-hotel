<?php

namespace App\Http\Controllers;

use App\Models\{Hotel, Review, Room};

class HomeController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('media')->take(5)->get();
        $rooms  = Room::with('media')->take(8)->get();
        $reviews = Review::with('user')->take(3)->get();

        return view('home', compact('hotels', 'rooms', 'reviews'));
    }
}
