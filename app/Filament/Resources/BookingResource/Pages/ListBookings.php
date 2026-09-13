<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Split bookings by trip date: upcoming (today onwards) in the first tab,
     * and bookings whose date has already passed in the second tab.
     */
    public function getTabs(): array
    {
        $today = Carbon::today();

        return [
            'upcoming' => Tab::make('Upcoming')
                ->badge(fn () => BookingResource::getEloquentQuery()->whereDate('pickup_at', '>=', $today)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('pickup_at', '>=', $today)),

            'past' => Tab::make('Past')
                ->badge(fn () => BookingResource::getEloquentQuery()->whereDate('pickup_at', '<', $today)->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('pickup_at', '<', $today)),

            'all' => Tab::make('All'),
        ];
    }
}
