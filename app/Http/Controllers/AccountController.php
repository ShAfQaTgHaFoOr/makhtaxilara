<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function bookings(Request $request)
    {
        $bookings = $request->user()->bookings()
            ->with('vehicle')
            ->latest()
            ->paginate(10);

        return view('account.bookings', compact('bookings'));
    }
}
