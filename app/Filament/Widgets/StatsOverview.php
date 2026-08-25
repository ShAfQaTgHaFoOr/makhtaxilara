<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BookingResource;
use App\Filament\Resources\ContactResource;
use App\Filament\Resources\DriverResource;
use App\Filament\Resources\VehicleResource;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Driver;
use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    protected function getStats(): array
    {
        $revenue = Booking::where('status', '!=', 'cancelled')->sum('fare_amount');

        return [
            Stat::make('Bookings', Booking::count())
                ->description(Booking::where('status', 'pending')->count() . ' pending')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning')
                ->url(BookingResource::getUrl('index')),

            Stat::make('Unread queries', Contact::where('is_read', false)->count())
                ->description('Customer enquiries')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color('info')
                ->url(ContactResource::getUrl('index')),

            Stat::make('Drivers', Driver::count())
                ->description(Driver::where('is_active', true)->count() . ' active')
                ->descriptionIcon('heroicon-m-identification')
                ->color('success')
                ->url(DriverResource::getUrl('index')),

            Stat::make('Active vehicles', Vehicle::where('is_active', true)->count())
                ->description('In the fleet')
                ->descriptionIcon('heroicon-m-truck')
                ->color('primary')
                ->url(VehicleResource::getUrl('index')),

            Stat::make('Estimated revenue', '$' . number_format((float) $revenue, 2))
                ->description('Excludes cancelled')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
