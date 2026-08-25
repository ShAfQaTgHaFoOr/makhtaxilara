<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('convert')
                ->label('Convert to booking')
                ->icon('heroicon-m-arrow-right-circle')
                ->color('success')
                ->visible(fn () => ! $this->record->isConverted())
                ->modalHeading('Convert query to booking')
                ->modalSubmitActionLabel('Create booking')
                ->fillForm(fn () => [
                    'passengers' => 1,
                    'notes' => $this->record->subject
                        ? $this->record->subject . ' — ' . $this->record->message
                        : $this->record->message,
                ])
                ->form(ContactResource::convertFormSchema())
                ->action(function (array $data) {
                    $booking = ContactResource::createBookingFromQuery($this->record, $data);

                    Notification::make()
                        ->success()
                        ->title("Booking {$booking->booking_no} created")
                        ->send();

                    $this->fillForm();
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
