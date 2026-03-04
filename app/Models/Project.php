<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    /**
     * The storage disk used for file uploads.
     */
    protected static string $storageDisk = 'public';

    /**
     * The attributes that contain file paths.
     */
    protected static array $fileFields = ['thumbnail'];

    protected static function booted(): void
    {
        // Clean up old files when updating
        static::updating(function (Project $project) {
            foreach (static::$fileFields as $field) {
                if ($project->isDirty($field)) {
                    $oldFile = $project->getOriginal($field);
                    if ($oldFile) {
                        Storage::disk(static::$storageDisk)->delete($oldFile);
                    }
                }
            }
        });

        // Clean up files when deleting
        static::deleting(function (Project $project) {
            foreach (static::$fileFields as $field) {
                if ($project->{$field}) {
                    Storage::disk(static::$storageDisk)->delete($project->{$field});
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
        'title',
        'slug',
        'excerpt',
        'content',
        'problem',
        'solution',
        'results',
        'client_name',
        'industry',
        'project_year',
        'thumbnail',
        'video_url',
        'service_type',
        'is_published',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the project's gallery images, ordered by sort_order.
     */
    public function images()
    {
        return $this->hasMany(ProjectImage::class)
            ->orderBy('sort_order');
    }
}
