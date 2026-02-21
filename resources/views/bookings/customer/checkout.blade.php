@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container">
        <h3 class="text-center" style="margin-top: 20px;">Checkout</h3>

        <div id="checkout"></div>
    </div>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");

        async function initialize() {
            try {
                const fetchClientSecret = async () => {
                    const response = await fetch("{{ route('stripe.session', $room->id) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        }
                    });

                    if (!response.ok) {
                        throw new Error("Unable to start checkout.");
                    }

                    const data = await response.json();
                    return data.clientSecret;
                };

                const checkout = await stripe.initEmbeddedCheckout({
                    fetchClientSecret,
                });

                checkout.mount('#checkout');

            } catch (error) {
                document.getElementById('checkout').innerHTML =
                    "<p>Unable to initialize payment. Please refresh.</p>";
            }
        }

        initialize();
    </script>
@endsection
