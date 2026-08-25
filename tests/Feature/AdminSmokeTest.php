<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_non_admin_cannot_access_panel(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_open_dashboard_and_resource_pages(): void
    {
        $admin = $this->admin();

        $urls = [
            '/admin',
            '/admin/vehicles', '/admin/vehicles/create',
            '/admin/bookings', '/admin/bookings/create',
            '/admin/pages', '/admin/pages/create',
            '/admin/posts', '/admin/posts/create',
            '/admin/contacts', '/admin/contacts/create',
        ];

        foreach ($urls as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }
}
