<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class InvoiceController extends Controller
{
    /** Shareable, printable HTML invoice (public link, keyed on the random booking_no). */
    public function show(string $booking_no)
    {
        $booking = Booking::with('vehicle')->where('booking_no', $booking_no)->firstOrFail();

        return view('invoices.booking', $this->viewData($booking, false));
    }

    /** Streamed PDF download of the invoice. */
    public function download(string $booking_no)
    {
        $booking = Booking::with('vehicle')->where('booking_no', $booking_no)->firstOrFail();

        $pdf = Pdf::loadView('invoices.booking', $this->viewData($booking, true));

        return $pdf->download('invoice-' . $booking->booking_no . '.pdf');
    }

    /** Shared view payload — includes a QR that links to this booking's online detail page. */
    private function viewData(Booking $booking, bool $pdf): array
    {
        return [
            'booking' => $booking,
            'pdf'     => $pdf,
            'qr'      => $this->qrDataUri(route('booking.invoice', $booking->booking_no)),
        ];
    }

    /** Build a scannable QR code as a base64 PNG data URI (works in both HTML and PDF). */
    private function qrDataUri(string $text): string
    {
        return Builder::create()
            ->writer(new PngWriter())
            ->data($text)
            ->size(200)
            ->margin(6)
            ->build()
            ->getDataUri();
    }
}
