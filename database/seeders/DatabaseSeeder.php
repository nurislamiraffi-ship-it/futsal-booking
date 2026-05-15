<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@futsal.com'],
            [
                'name' => 'Admin Futsal',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@futsal.com'],
            [
                'name' => 'User Pelanggan',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '089876543210',
            ]
        );

        $lapanganA = Lapangan::updateOrCreate(
            ['name' => 'Lapangan Sintetis A'],
            [
                'description' => 'Lapangan rumput sintetis standar internasional.',
                'price_per_hour' => 150000,
            ]
        );

        $lapanganB = Lapangan::updateOrCreate(
            ['name' => 'Lapangan Vinyl B'],
            [
                'description' => 'Lapangan lantai vinyl anti slip.',
                'price_per_hour' => 120000,
            ]
        );

        // Create sample schedules for the next 3 days
        foreach ([$lapanganA, $lapanganB] as $lapangan) {
            for ($i = 0; $i < 3; $i++) {
                $date = now()->addDays($i)->toDateString();
                
                // Morning slot
                \App\Models\Jadwal::updateOrCreate(
                    [
                        'lapangan_id' => $lapangan->id,
                        'date' => $date,
                        'start_time' => '08:00:00',
                    ],
                    [
                        'end_time' => '09:00:00',
                        'is_available' => true,
                    ]
                );

                // Afternoon slot
                \App\Models\Jadwal::updateOrCreate(
                    [
                        'lapangan_id' => $lapangan->id,
                        'date' => $date,
                        'start_time' => '16:00:00',
                    ],
                    [
                        'end_time' => '17:00:00',
                        'is_available' => true,
                    ]
                );

                // Night slot
                \App\Models\Jadwal::updateOrCreate(
                    [
                        'lapangan_id' => $lapangan->id,
                        'date' => $date,
                        'start_time' => '20:00:00',
                    ],
                    [
                        'end_time' => '21:00:00',
                        'is_available' => true,
                    ]
                );
            }
        }
    }
}
