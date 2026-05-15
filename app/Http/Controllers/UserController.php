<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $lapangans = Lapangan::all();
        $myBookings = Booking::with(['lapangan', 'pembayaran'])->where('user_id', auth()->id())->latest()->get();
        return view('user.dashboard', compact('lapangans', 'myBookings'));
    }

    public function createBooking($lapangan_id)
    {
        $lapangan = Lapangan::findOrFail($lapangan_id);
        $jadwals = Jadwal::where('lapangan_id', $lapangan_id)
            ->where('is_available', true)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
        return view('user.booking', compact('lapangan', 'jadwals'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        $jadwal = Jadwal::findOrFail($request->jadwal_id);
        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        if (!$jadwal->is_available) {
            return back()->with('error', 'Jadwal tidak tersedia.');
        }

        // Calculate hours
        $start = strtotime($jadwal->start_time);
        $end = strtotime($jadwal->end_time);
        $hours = round(abs($end - $start) / 3600, 2);
        if ($hours <= 0) $hours = 1;
        
        $totalPrice = $hours * $lapangan->price_per_hour;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'lapangan_id' => $lapangan->id,
            'booking_date' => $jadwal->date,
            'start_time' => $jadwal->start_time,
            'end_time' => $jadwal->end_time,
            'total_price' => $totalPrice,
            'status' => 'Menunggu Pembayaran',
        ]);

        $jadwal->update(['is_available' => false]);

        return redirect()->route('user.pembayaran.create', $booking->id)->with('success', 'Booking berhasil, silakan lakukan pembayaran.');
    }

    public function pembayaran($booking_id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($booking_id);
        return view('user.pembayaran', compact('booking'));
    }

    public function storePembayaran(Request $request, $booking_id)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $booking = Booking::where('user_id', auth()->id())->findOrFail($booking_id);

        if ($request->hasFile('proof_image')) {
            $imagePath = $request->file('proof_image')->store('pembayaran', 'public');
            
            Pembayaran::create([
                'booking_id' => $booking->id,
                'proof_image' => $imagePath,
                'amount' => $booking->total_price,
                'status' => 'Pending',
                'paid_at' => now(),
            ]);

            $booking->update(['status' => 'Diproses']);
        }

        return redirect()->route('user.dashboard')->with('success', 'Pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }
}
