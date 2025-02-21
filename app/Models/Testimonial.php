<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'visibility',
        'star_quantity',
        'hotel_id',
        'user_id'
    ];

    public function user () {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function hotel () :BelongsTo {
        return $this->belongsTo(Company::class, 'hotel_id', 'id');
    }
}
