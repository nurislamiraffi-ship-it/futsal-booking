<?php

namespace App\Http\Controllers;

use App\Models\Sparring;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class SparringController extends Controller
{
    public function index()
    {
        $sparrings = Sparring::with(['user', 'lapangan'])
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
            
        return view('sparring.index', compact('sparrings'));
    }

    public function create()
    {
        $lapangans = Lapangan::all();
        return view('sparring.create', compact('lapangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'description' => 'nullable|string|max:500',
        ]);

        Sparring::create([
            'user_id' => auth()->id(),
            'lapangan_id' => $request->lapangan_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'status' => 'Open',
        ]);

        return redirect()->route('sparring.index')->with('success', 'Slot sparring berhasil dibuka!');
    }

    public function join($id)
    {
        $sparring = Sparring::findOrFail($id);
        
        if ($sparring->user_id == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa join di slot Anda sendiri.');
        }

        if ($sparring->status !== 'Open') {
            return back()->with('error', 'Slot ini sudah penuh atau ditutup.');
        }

        $sparring->update(['status' => 'Matched']);

        return back()->with('success', 'Berhasil join sparring! Silakan hubungi pembuat slot untuk koordinasi.');
    }
}
