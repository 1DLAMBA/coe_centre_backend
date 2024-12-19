<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'full_name',
        'phone_number',
        'reference',
        'passport',
        'has_paid',
        'programme',
        'application_number',
        'payment_date',
    ];
}
