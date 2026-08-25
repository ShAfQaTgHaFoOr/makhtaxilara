<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'role', 'permissions', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /** Available resource permissions (key => label). */
    public const PERMISSIONS = [
        'bookings' => 'Bookings',
        'queries'  => 'Queries (enquiries)',
        'drivers'  => 'Drivers',
        'fleet'    => 'Fleet (vehicles)',
        'routes'   => 'Routes',
        'packages' => 'Packages',
        'content'  => 'Content (pages & posts)',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_admin;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /** Can this user access a given resource area? Super admins can access everything. */
    public function canAccessResource(string $key): bool
    {
        return $this->isSuperAdmin() || in_array($key, (array) ($this->permissions ?? []), true);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'permissions' => 'array',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /** Bookings this panel user created. */
    public function createdBookings()
    {
        return $this->hasMany(Booking::class, 'created_by');
    }
}
