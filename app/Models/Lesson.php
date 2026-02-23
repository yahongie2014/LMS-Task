<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lesson extends Model
{
    use HasFactory, \App\Traits\HasFiles;

    protected $appends = ['title', 'description'];

    protected $fillable = [
        'course_id',
        'title_en',
        'title_ar',
        'slug',
        'description_en',
        'description_ar',
        'video_type',
        'video_url',
        'duration',
        'order_column',
        'is_preview',
        'is_published',
    ];

    protected $casts = [
        'is_preview' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function completions()
    {
        return $this->hasMany(LessonCompletion::class);
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
