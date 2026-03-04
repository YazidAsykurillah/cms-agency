<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectImage extends Model
{
    /**
     * The storage disk used for file uploads.
     */
    protected static string $storageDisk = 'public';

    /**
     * The attributes that contain file paths.
     */
    protected static array $fileFields = ['image_path'];

    protected static function booted(): void
    {
        // Clean up old files when updating
        static::updating(function (ProjectImage $image) {
            foreach (static::$fileFields as $field) {
                if ($image->isDirty($field)) {
                    $oldFile = $image->getOriginal($field);
                    if ($oldFile) {
                        Storage::disk(static::$storageDisk)->delete($oldFile);
                    }
                }
            }
        });

        // Clean up files when deleting
        static::deleting(function (ProjectImage $image) {
            foreach (static::$fileFields as $field) {
                if ($image->{$field}) {
                    Storage::disk(static::$storageDisk)->delete($image->{$field});
                }
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'image_path',
        'caption',
        'sort_order',
    ];

    /**
     * Get the project that owns the image.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
