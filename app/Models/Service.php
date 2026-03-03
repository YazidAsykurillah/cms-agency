<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    /**
     * The storage disk used for file uploads.
     */
    protected static string $storageDisk = 'public';

    /**
     * The attributes that contain file paths.
     */
    protected static array $fileFields = ['featured_image', 'og_image'];

    protected static function booted(): void
    {
        // Clean up old files when updating
        static::updating(function (Service $service) {
            foreach (static::$fileFields as $field) {
                if ($service->isDirty($field)) {
                    $oldFile = $service->getOriginal($field);
                    if ($oldFile) {
                        Storage::disk(static::$storageDisk)->delete($oldFile);
                    }
                }
            }
        });

        // Clean up files when deleting
        static::deleting(function (Service $service) {
            foreach (static::$fileFields as $field) {
                if ($service->{$field}) {
                    Storage::disk(static::$storageDisk)->delete($service->{$field});
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
        'name',
        'slug',
        'short_description',
        'full_description',
        'featured_image',
        'problem_statement',
        'solution_approach',
        'process_steps',
        'faq',
        'call_to_action_text',
        'featured',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'featured' => 'boolean',
        'process_steps' => 'array',
        'faq' => 'array',
    ];
}
