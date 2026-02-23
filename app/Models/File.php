<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'file_name',
        'fileable_type',
        'fileable_id',
        'file_type',
        'file_size',
        'folder',
        'label',
        'notes',
        'order',
        'is_active',
    ];

    /**
     * Get the owning fileable model.
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    /**
     * Get the full URL of the file.
     */
    public function getUrlAttribute()
    {
        // If file_name starts with the folder name, don't prefix it again
        if ($this->folder && str_starts_with($this->file_name, $this->folder . '/')) {
            return Storage::disk('public')->url($this->file_name);
        }

        $path = $this->folder ? $this->folder . '/' . $this->file_name : $this->file_name;
        return Storage::disk('public')->url($path);
    }
}
