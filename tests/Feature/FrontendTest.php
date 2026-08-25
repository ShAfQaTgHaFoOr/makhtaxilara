<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Page;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    private function vehicle(): Vehicle
    {
        return Vehicle::create([
            'name' => 'Camry Cars', 'slug' => 'camry-cars', 'excerpt' => 'Comfy sedan',
            'passengers' => 4, 'luggage' => 3,
            'base_fare' => 15, 'per_km' => 2.5, 'per_hour' => 25, 'min_fare' => 20,
            'is_active' => true,
        ]);
    }

    public function test_public_pages_render(): void
    {
        $this->vehicle();
        Page::create(['title' => 'About Us', 'slug' => 'about-us', 'content' => '<p>Hi</p>', 'is_published' => true]);

        $this->get('/')->assertOk();
        $this->get('/our-taxis')->assertOk()->assertSee('Camry Cars');
        $this->get('/vehicle/camry-cars')->assertOk();
        $this->get('/about-us')->assertOk()->assertSee('About Us');
        $this->get('/contact-us')->assertOk();
        $this->get('/booking')->assertOk();
        $this->get('/blog')->assertOk();
    }

    public function test_fare_estimate_endpoint(): void
    {
        $v = $this->vehicle();
        $this->postJson('/booking/estimate', [
            'vehicle_id' => $v->id, 'trip_type' => 'distance', 'distance_km' => 20,
        ])->assertOk()->assertJson(['fare' => 65]); // 15 + 20*2.5
    }

    public function test_booking_can_be_created_and_paid_as_cash(): void
    {
        $v = $this->vehicle();

        $res = $this->post('/booking', [
            'vehicle_id' => $v->id, 'name' => 'Ali', 'email' => 'ali@example.com', 'phone' => '123',
            'trip_type' => 'distance', 'pickup_location' => 'Makkah', 'dropoff_location' => 'Jeddah',
            'pickup_at' => now()->addDay()->format('Y-m-d\TH:i'), 'distance_km' => 20, 'passengers' => 2,
        ]);

        $booking = Booking::first();
        $this->assertNotNull($booking);
        $this->assertEquals(65.0, (float) $booking->fare_amount);
        $res->assertRedirect(route('booking.confirmation', $booking->booking_no));

        // No Stripe keys in testing -> checkout falls back to cash + confirmation.
        $this->get(route('payment.checkout', $booking->booking_no))
            ->assertRedirect(route('booking.confirmation', $booking->booking_no));
        $this->assertEquals('cash', $booking->fresh()->payment_method);
    }

    public function test_register_login_and_view_bookings(): void
    {
        $this->post('/register', [
            'name' => 'New User', 'email' => 'new@example.com', 'phone' => '555',
            'password' => 'Secret123!', 'password_confirmation' => 'Secret123!',
        ])->assertRedirect(route('account.bookings'));

        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);

        auth()->logout();

        $this->post('/login', ['email' => 'new@example.com', 'password' => 'Secret123!'])
            ->assertRedirect(route('account.bookings'));

        $user = User::where('email', 'new@example.com')->first();
        $this->actingAs($user)->get('/my-bookings')->assertOk()->assertSee('My Bookings');
    }
}
