<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        "companyname",
        "company_cover_photo",
        "location",
        "email",
        "phone",
        "province",
        "municipality",
        "country"
        ];   
}
