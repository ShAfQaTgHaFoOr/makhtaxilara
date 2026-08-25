<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    private function booking(string $bookingNo): Booking
    {
        return Booking::with('vehicle')->where('booking_no', $bookingNo)->firstOrFail();
    }

    /** Start payment. Uses Stripe Checkout when configured, otherwise falls back to pay-on-arrival. */
    public function checkout(string $booking_no)
    {
        $booking = $this->booking($booking_no);
        $secret  = config('services.stripe.secret');

        // No Stripe keys yet -> record as cash / pay on arrival.
        if (! $secret) {
            $booking->update(['payment_method' => 'cash', 'payment_status' => 'unpaid']);

            return redirect()
                ->route('booking.confirmation', $booking->booking_no)
                ->with('status', 'Card payments are not enabled yet — your driver will collect the fare on arrival.');
        }

        Stripe::setApiKey($secret);

        $session = StripeSession::create([
            'mode'        => 'payment',
            'line_items'  => [[
                'quantity'   => 1,
                'price_data' => [
                    'currency'     => config('services.stripe.currency', 'usd'),
                    'unit_amount'  => (int) round($booking->fare_amount * 100),
                    'product_data' => [
                        'name' => 'Ride booking ' . $booking->booking_no
                                . ' — ' . ($booking->vehicle?->name ?? 'Taxi'),
                    ],
                ],
            ]],
            'customer_email'      => $booking->email,
            'success_url'         => route('payment.success', $booking->booking_no) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'          => route('booking.confirmation', $booking->booking_no),
            'metadata'            => ['booking_no' => $booking->booking_no],
        ]);

        $booking->update(['payment_method' => 'stripe', 'payment_reference' => $session->id]);

        return redirect()->away($session->url);
    }

    public function success(Request $request, string $booking_no)
    {
        $booking = $this->booking($booking_no);
        $secret  = config('services.stripe.secret');

        if ($secret && $request->query('session_id')) {
            Stripe::setApiKey($secret);
            $session = StripeSession::retrieve($request->query('session_id'));
            if ($session->payment_status === 'paid') {
                $booking->update(['payment_status' => 'paid', 'status' => 'confirmed']);
            }
        }

        return redirect()
            ->route('booking.confirmation', $booking->booking_no)
            ->with('status', 'Payment received — your booking is confirmed. Thank you!');
    }
}
