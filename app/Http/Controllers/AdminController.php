<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBookings = Booking::count();
        $totalLapangan = Lapangan::count();
        $recentBookings = Booking::with(['user', 'lapangan'])->latest()->take(5)->get();
        
        // Data for charts
        $labels = [];
        $bookingData = [];
        $revenueData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = now()->subDays($i)->format('d M');
            
            $bookingData[] = Booking::whereDate('created_at', $date)->count();
            $revenueData[] = Booking::whereDate('created_at', $date)
                ->where('status', 'Disetujui')
                ->sum('total_price');
        }
        
        return view('admin.dashboard', compact(
            'totalBookings', 
            'totalLapangan', 
            'recentBookings',
            'labels',
            'bookingData',
            'revenueData'
        ));
    }

    public function lapanganIndex()
    {
        $lapangans = Lapangan::all();
        return view('admin.lapangan.index', compact('lapangans'));
    }

    public function lapanganStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_hour' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('lapangan', 'public');
            $data['image'] = $imagePath;
        }

        Lapangan::create($data);
        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function lapanganEdit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function lapanganUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_hour' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $lapangan = Lapangan::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($lapangan->image && \Storage::disk('public')->exists($lapangan->image)) {
                \Storage::disk('public')->delete($lapangan->image);
            }
            $imagePath = $request->file('image')->store('lapangan', 'public');
            $data['image'] = $imagePath;
        } elseif ($request->boolean('remove_image')) {
            // Delete image if user checked the removal checkbox
            if ($lapangan->image && \Storage::disk('public')->exists($lapangan->image)) {
                \Storage::disk('public')->delete($lapangan->image);
            }
            $data['image'] = null;
        }

        $lapangan->update($data);
        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function lapanganDestroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        $lapangan->delete();
        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil dihapus.');
    }

    public function jadwalIndex()
    {
        $jadwals = Jadwal::with('lapangan')->orderBy('date')->get();
        $lapangans = Lapangan::all();
        return view('admin.jadwal.index', compact('jadwals', 'lapangans'));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $data = $request->all();
        $data['is_available'] = true;

        Jadwal::create($data);
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function jadwalEdit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $lapangans = Lapangan::all();
        return view('admin.jadwal.edit', compact('jadwal', 'lapangans'));
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'is_available' => 'required|boolean',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function jadwalDestroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function bookingIndex()
    {
        $bookings = Booking::with(['user', 'lapangan', 'pembayaran'])->orderBy('created_at', 'desc')->get();
        return view('admin.booking.index', compact('bookings'));
    }

    public function bookingApprove($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'Disetujui']);
        return back()->with('success', 'Booking disetujui.');
    }

    public function bookingReject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'Ditolak']);
        
        // Return jadwal availability
        $jadwal = Jadwal::where('lapangan_id', $booking->lapangan_id)
            ->where('date', $booking->booking_date)
            ->where('start_time', $booking->start_time)
            ->first();
        if ($jadwal) {
            $jadwal->update(['is_available' => true]);
        }
            
        return back()->with('success', 'Booking ditolak.');
    }
}
