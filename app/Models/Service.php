<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
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
        'icon',
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
