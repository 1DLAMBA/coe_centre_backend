<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'course', 'course_code'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
