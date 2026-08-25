<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Contact;
use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $revenue = Booking::where('status', '!=', 'cancelled')->sum('fare_amount');

        return [
            Stat::make('Bookings', Booking::count())
                ->description(Booking::where('status', 'pending')->count() . ' pending')
                ->color('warning'),

            Stat::make('Estimated revenue', '$' . number_format((float) $revenue, 2))
                ->description('Excludes cancelled')
                ->color('success'),

            Stat::make('Active vehicles', Vehicle::where('is_active', true)->count())
                ->color('primary'),

            Stat::make('New messages', Contact::where('is_read', false)->count())
                ->color('info'),
        ];
    }
}
