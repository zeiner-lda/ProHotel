<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ["product", "category_id", "hotel_id", "user_id"];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
