<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity_days',
        'reservation_id',
        'notes',
        'payment_method',
        'total_amount',
        'status',
        'hotel_id'
     ];

     public function reservation() {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }
}
