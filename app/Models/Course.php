<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Course extends Model
{
    use HasFactory, SoftDeletes, \App\Traits\HasFiles;

    protected $appends = ['title', 'description'];

    protected $fillable = [
        'title_en',
        'title_ar',
        'slug',
        'description_en',
        'description_ar',
        'image',
        'level',
        'price',
        'duration',
        'is_published',
        'instructor_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order_column');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() === 'ar' && !empty($this->title_ar) ? $this->title_ar : $this->title_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' && !empty($this->description_ar) ? $this->description_ar : $this->description_en;
    }
}
