<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_booking_successfully(): void
    {
        $user = \App\Models\User::factory()->create();
        $court = \App\Models\Court::create([
            'name' => 'Lapangan Test',
            'price_per_hour' => 100000,
            'description' => 'Test'
        ]);

        $response = $this->actingAs($user)->post('/bookings', [
            'court_id' => $court->id,
            'start_time' => now()->addHours(1)->format('Y-m-d H:i:s'),
            'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect('/bookings');
        $this->assertDatabaseHas('bookings', [
            'court_id' => $court->id,
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
    }

    public function test_user_cannot_book_overlapping_time(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();
        
        $court = \App\Models\Court::create([
            'name' => 'Lapangan Test',
            'price_per_hour' => 100000,
            'description' => 'Test'
        ]);

        $startTime = now()->addDays(1)->setHour(10)->setMinute(0)->setSecond(0);
        $endTime = now()->addDays(1)->setHour(12)->setMinute(0)->setSecond(0);

        // Booking pertama sukses
        $this->actingAs($user1)->post('/bookings', [
            'court_id' => $court->id,
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
        ]);

        // Booking kedua di waktu yang bentrok
        $response = $this->actingAs($user2)->post('/bookings', [
            'court_id' => $court->id,
            'start_time' => $startTime->addMinutes(30)->format('Y-m-d H:i:s'),
            'end_time' => $endTime->addMinutes(30)->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors('end_time');
        $this->assertEquals(1, \App\Models\Booking::count());
    }
}
