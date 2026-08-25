<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('invoice')
                ->label('View / share invoice')
                ->icon('heroicon-m-document-text')
                ->color('gray')
                ->url(fn () => route('booking.invoice', $this->record->booking_no))
                ->openUrlInNewTab(),
            Actions\Action::make('invoicePdf')
                ->label('Download PDF')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('success')
                ->url(fn () => route('booking.invoice.download', $this->record->booking_no))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
