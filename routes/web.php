<?php

use App\Http\Controllers\{
    BookingController,
    DashboardController,
    DiscountController,
    HomeController,
    HotelController,
    PromotionController,
    ReviewController,
    RoomController,
    StripeController,
    UploadController,
    UserController,
};
use Illuminate\Support\Facades\{Auth, Route};

Auth::routes(['verify' => true]);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('privacy', 'privacy')->name('privacy');

Route::view('cancellation', 'cancellation')->name('cancellation');

Route::get('/hotels/list', [HotelController::class, 'customer'])->name('customer.hotels.index');

Route::get('/rooms/list/{hotel?}', [RoomController::class, 'customer'])->name('customer.rooms.index');

Route::get('show/rooms/{room}', [RoomController::class, 'customerShow'])->name('customer.rooms.show');

Route::get('discount/codes', [DiscountController::class, 'customer'])->name('customer.discounts.index');

Route::middleware('auth', 'verified')->group(function () {

    Route::get('workspace', [DashboardController::class, 'index'])->name('dashboard');

    // Hotel Manager Routes
    Route::middleware('role:hotel_manager')->group(function () {

        Route::get('my/hotel', [HotelController::class, 'manager'])->name('manager.hotels.index');

        Route::get('hotels/create', [HotelController::class, 'create'])->name('hotels.create');

        Route::post('hotels/store', [HotelController::class, 'store'])->name('hotels.store');

        Route::get('my/rooms', [RoomController::class, 'manager'])->name('manager.rooms.index');

        Route::get('rooms/create', [RoomController::class, 'create'])->name('rooms.create');

        Route::post('rooms/store', [RoomController::class, 'store'])->name('rooms.store');

        Route::get('manager/reviews', [ReviewController::class, 'manager'])->name('manager.reviews.index');

        Route::get('manager/bookings', [BookingController::class, 'manager'])->name('manager.bookings.index');

        Route::resource('promotions', PromotionController::class);

        Route::patch('/bookings/{booking}/refund', [BookingController::class, 'refund'])
            ->name('bookings.refund');
    });

    // Admin Routes
    Route::middleware('role:admin')->group(function () {

        Route::get('hotels', [HotelController::class, 'index'])->name('hotels.index');

        Route::resource('users', UserController::class)->except('destroy');

        Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');

        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');

        Route::resource('discounts', DiscountController::class)->except('show');
    });

    // Admin and Hotel Manager Routes
    Route::middleware('role:hotel_manager|admin')->group(function () {

        Route::post('uploads', [UploadController::class, 'upload']);

        Route::delete('/uploads/revert/{folder}', [UploadController::class, 'revert']);

        Route::delete('/hotels/{media}/delete', [HotelController::class, 'destroyMedia']);

        Route::delete('/rooms/{media}/delete', [RoomController::class, 'destroyMedia']);

        Route::resource('hotels', HotelController::class)->except('create', 'store', 'index');

        Route::resource('rooms', RoomController::class)->except('create', 'store', 'index');
    });

    // Customer Routes
    Route::middleware('role:customer')->group(function () {
        Route::post('/bookings/prepare', [BookingController::class, 'prepare'])->name('bookings.prepare');

        Route::get('/bookings/checkout/{room}', [BookingController::class, 'checkout'])
            ->name('bookings.checkout');

        Route::post('/stripe/session/{room}', [StripeController::class, 'createSession'])->name('stripe.session');

        Route::post('/stripe/status', [StripeController::class, 'checkStatus'])->name('stripe.status');

        Route::get('/stripe/return', [StripeController::class, 'returnPage'])->name('stripe.return');

        Route::get('customer/bookings', [BookingController::class, 'customer'])->name('customer.bookings.index');

        Route::post('discounts/{discount}/redeem', [DiscountController::class, 'redeem'])
            ->name('discounts.redeem');

        Route::post('discounts/validate', [DiscountController::class, 'validateCode'])
            ->name('discounts.validate');

        Route::get('discounts/redeemed', [DiscountController::class, 'redeemedList'])
            ->name('customer.discounts.redeemed');

        Route::get('reviews/create/{booking}', [ReviewController::class, 'create'])->name('reviews.create');

        Route::post('reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

        Route::delete('reviews/delete/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::get('customer/reviews', [ReviewController::class, 'customer'])->name('customer.reviews.index');

        Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
            ->name('bookings.cancel');
    });

    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    Route::get('reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
});
