<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'notification_title',
         'notification',
        'status' ,
        'reservation_id',
        'hotel_id'
        ];

        public function reservation() {
            return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
        }
}
