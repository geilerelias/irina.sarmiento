<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicDocument extends Model
{
    protected $fillable = [
        'title',
        'description',
        'published_at',
        'file_path',
        'category',
    ];
}
