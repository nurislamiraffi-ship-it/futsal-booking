<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::all();
        return view('home', compact('lapangans'));
    }
}
