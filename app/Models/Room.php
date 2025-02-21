<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        "room_number",
        "room_type", "capacity",
        "price_pernight", "status",
        "bed_quantity",
        "bath_quantity",
        "description",
        "hotel_id",
        "photo"
    ];
}
