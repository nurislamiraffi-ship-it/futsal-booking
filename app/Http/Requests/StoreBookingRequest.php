<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'court_id' => 'required|exists:courts,id',
            'start_time' => 'required|date|after:now',
            'end_time' => [
                'required',
                'date',
                'after:start_time',
                function ($attribute, $value, $fail) {
                    $courtId = $this->input('court_id');
                    $startTime = $this->input('start_time');
                    $endTime = $value;

                    if ($courtId && $startTime && $endTime) {
                        $conflict = \App\Models\Booking::where('court_id', $courtId)
                            ->where(function ($query) use ($startTime, $endTime) {
                                $query->whereBetween('start_time', [$startTime, $endTime])
                                      ->orWhereBetween('end_time', [$startTime, $endTime])
                                      ->orWhere(function ($q) use ($startTime, $endTime) {
                                          $q->where('start_time', '<=', $startTime)
                                            ->where('end_time', '>=', $endTime);
                                      });
                            })
                            ->exists();

                        if ($conflict) {
                            $fail('Waktu lapangan sudah dipesan oleh orang lain. Silakan pilih waktu lain.');
                        }
                    }
                },
            ],
        ];
    }
}
