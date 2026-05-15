<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = \App\Models\Booking::where('user_id', auth()->id())->with('court')->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create(\App\Models\Court $court)
    {
        return view('bookings.create', compact('court'));
    }

    public function store(\App\Http\Requests\StoreBookingRequest $request)
    {
        \App\Models\Booking::create([
            'user_id' => auth()->id(),
            'court_id' => $request->court_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil dibuat dan menunggu konfirmasi.');
    }

    public function cancel(\App\Models\Booking $booking)
    {
        if ($booking->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $booking->update(['status' => 'canceled']);
        return back()->with('success', 'Pemesanan dibatalkan.');
    }

    public function adminDashboard()
    {
        $bookings = \App\Models\Booking::with(['user', 'court'])->latest()->get();
        $totalCourts = \App\Models\Court::count();
        $totalBookings = \App\Models\Booking::count();

        return view('admin.dashboard', compact('bookings', 'totalCourts', 'totalBookings'));
    }

    public function confirm(\App\Models\Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Pemesanan berhasil dikonfirmasi.');
    }
}
