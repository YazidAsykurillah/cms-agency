<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Core Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();

            // Case Study Sections
            $table->longText('problem')->nullable();
            $table->longText('solution')->nullable();
            $table->longText('results')->nullable();

            // Client Information
            $table->string('client_name')->nullable();
            $table->string('industry')->nullable();
            $table->year('project_year')->nullable();

            // Media
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();

            // Positioning
            $table->string('service_type')->nullable();

            // Publishing
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();

            $table->index('slug');
            $table->index('is_published');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
