<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderClient extends Model
{
    use HasFactory;
    protected $fillable = [
        "order_name",
        "order_price",
        "order_room",
        "order_quantity",
        "order_photo",
        "status",
        "order_status",
        "user_id",
        "item_id",
        "hotel_id"
    ];

    public function hotel () {
        return $this->belongsTo(Company::class, 'hotel_id', 'id');
    }
}
