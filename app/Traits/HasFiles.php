<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasFiles
{
    /**
     * Get all of the model's files.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable')->orderBy('order');
    }

    /**
     * Get the first file with a specific label.
     */
    public function getFileByLabel($label)
    {
        return $this->files()->where('label', $label)->first();
    }

    /**
     * Upload and attach a file to the model.
     */
    public function addFile(UploadedFile $file, $folder = 'uploads', $label = null, $notes = null)
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $fileName, 'public');

        return $this->files()->create([
            'file_name' => $fileName,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'folder' => $folder,
            'label' => $label,
            'notes' => $notes,
            'is_active' => true,
        ]);
    }

    /**
     * Sync files for a specific label (delete old, add new).
     */
    public function syncFile(UploadedFile $file, $folder = 'uploads', $label = null, $notes = null)
    {
        if ($label) {
            $oldFiles = $this->files()->where('label', $label)->get();
            foreach ($oldFiles as $oldFile) {
                Storage::disk('public')->delete(($oldFile->folder ? $oldFile->folder . '/' : '') . $oldFile->file_name);
                $oldFile->delete();
            }
        }

        return $this->addFile($file, $folder, $label, $notes);
    }
}
