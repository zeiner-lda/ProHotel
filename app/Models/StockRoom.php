<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'item',
        'quantity',
        'description',
        'product_id',
        'hotel_id',
        'user_id'
    ];

    public function user(): BelongsTo{
    return $this->belongsTo(User::class, "user_id" , "id");
    }
}
