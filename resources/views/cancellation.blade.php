@extends('layouts.app')

@section('title', 'Cancellation Policy')

@section('css')
    <style>
        h5 {
            margin: 10px 0;
        }
    </style>
@endsection

@section('content')
    <section class="thmv-about">
        <div class="container">
            <div class="row">
                <div class="thmv-sec-title text-center">
                    <h2 class="thmv-title-effect-center text-uppercase my-3">Cancellation Policy</h2>
                </div>

                <div class="thmv-about-info w-75 mx-auto">
                    <p>Effective Date: November 25, 2025</p>

                    <p>
                        At <strong>BookMyHotel</strong>, we understand that travel plans may change.
                        This Cancellation Policy explains how you can cancel or modify your bookings and how refunds are
                        handled.
                        By using our platform, you agree to the terms described below.
                    </p>

                    <h5>1. Free Cancellation Period</h5>
                    <p>
                        Most hotel bookings can be cancelled free of charge within a specific time frame.
                        The free cancellation deadline is clearly shown on the hotel listing and during checkout.
                    </p>

                    <h5>2. Non-Refundable Bookings</h5>
                    <p>
                        Some special deals and discounted rates are non-refundable and cannot be cancelled or modified.
                        These conditions will be clearly stated before you complete your booking.
                    </p>

                    <h5>3. Late Cancellations</h5>
                    <p>
                        If you cancel after the free cancellation period, you may be charged a cancellation fee
                        which can be up to the total cost of one night’s stay, depending on the hotel’s policy.
                    </p>

                    <h5>4. No-Show Policy</h5>
                    <p>
                        If you do not arrive at the hotel on your scheduled check-in date and do not inform us in advance,
                        your booking will be marked as a "no-show" and the full amount may be charged.
                    </p>

                    <h5>5. How to Cancel a Booking</h5>
                    <ul>
                        <li>Log in to your BookMyHotel account</li>
                        <li>Go to “My Bookings”</li>
                        <li>Select the reservation you want to cancel</li>
                        <li>Click on the “Cancel Booking” button and follow the instructions</li>
                    </ul>

                    <h5>6. Refunds</h5>
                    <p>
                        Eligible refunds are processed back to the original payment method.
                        Refund processing times may vary depending on your bank or payment provider.
                    </p>

                    <h5>7. Modifications</h5>
                    <p>
                        Changes to booking dates, guest details, or room types are subject to hotel availability and
                        may result in price differences.
                    </p>

                    <h5>8. Force Majeure</h5>
                    <p>
                        In exceptional circumstances such as natural disasters, government restrictions,
                        or public emergencies, special cancellation terms may apply.
                    </p>

                    <h5>9. Policy Updates</h5>
                    <p>
                        We reserve the right to update this Cancellation Policy at any time.
                        Changes will be posted on this page with an updated effective date.
                    </p>

                    <h5>10. Contact Us</h5>
                    <p>If you have any questions about this policy, you can contact us at:</p>

                    <p>
                        <strong>BookMyHotel</strong><br>
                        Email: <a href="mailto:support@bookmyhotel.com">support@bookmyhotel.com</a><br>
                        Phone: +1 (800) 123-4567<br>
                        Address: 123 Hotel Avenue, City, Country
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
