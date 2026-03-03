<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'agency_name',
        'tagline',
        'description',
        'logo_light',
        'logo_dark',
        'favicon',
        'email',
        'phone',
        'mobile_number',
        'address',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'tiktok_url',
        'default_meta_title',
        'default_meta_description',
        'default_og_image',
        'head_script',
        'body_script',
    ];

    /**
     * Get the singleton settings instance, creating it if it doesn't exist.
     */
    public static function getSettings()
    {
        return cache()->rememberForever('global_settings', function () {
            // First or create with default values to ensure a record always exists
            return self::firstOrCreate(
                [], // Empty condition to just find the first record
                [
                    'agency_name' => 'Agency Name',
                    'email' => 'hello@example.com',
                    'phone' => '+1234567890',
                    'mobile_number' => '+1234567890',
                    'default_meta_title' => 'Default Title',
                    'default_meta_description' => 'Default Description',
                ]
            );
        });
    }

    /**
     * Clear the settings cache whenever the model is saved/updated/deleted.
     */
    protected static function booted()
    {
        static::updating(function ($setting) {
            $imageFields = ['logo_light', 'logo_dark', 'favicon', 'default_og_image'];
            
            foreach ($imageFields as $field) {
                if ($setting->isDirty($field)) {
                    $oldImage = $setting->getOriginal($field);
                    if (!empty($oldImage) && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldImage)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImage);
                    }
                }
            }
        });

        static::saved(function () {
            cache()->forget('global_settings');
        });

        static::deleted(function () {
            cache()->forget('global_settings');
        });
    }
}
