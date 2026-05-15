<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\Lapangan;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $lapangans = Lapangan::all();
        
        foreach ($lapangans as $lapangan) {
            for ($i = 0; $i < 7; $i++) {
                $date = now()->addDays($i)->toDateString();
                
                // Slots from 08:00 to 22:00
                for ($hour = 8; $hour < 23; $hour++) {
                    $startTime = sprintf('%02d:00:00', $hour);
                    $endTime = sprintf('%02d:00:00', $hour + 1);
                    
                    Jadwal::create([
                        'lapangan_id' => $lapangan->id,
                        'date' => $date,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'is_available' => true,
                    ]);
                }
            }
        }
    }
}
