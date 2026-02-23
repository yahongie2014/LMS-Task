<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $appends = ['name', 'description'];

    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'description_en',
        'description_ar',
        'price',
        'duration_months',
        'is_active',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' && !empty($this->name_ar) ? $this->name_ar : $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' && !empty($this->description_ar) ? $this->description_ar : $this->description_en;
    }
}
