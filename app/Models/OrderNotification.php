<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        "notification_title",
        "notification",
        "status",
        "hotel_id",
        "guest_id"
    ];
}
