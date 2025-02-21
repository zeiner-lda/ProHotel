<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        "reservation_date",
        "reservation_hour",
        "reservation_status",
        "antecipated_reservation_date",
        "room_id",
        "guest_id",
        "hotel_id",
        ];

        public function room(): BelongsTo {
            return $this->belongsTo(Room::class);
        }

        public function guest() {
            return $this->belongsTo(Guest::class, 'guest_id', 'id');
        }

        public function hotel () {
            return $this->belongsTo(Company::class, 'hotel_id', 'id');
        }
}
