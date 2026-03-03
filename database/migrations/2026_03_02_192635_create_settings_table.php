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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // General Information
            $table->string('agency_name');
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();

            // Branding Assets
            $table->string('logo_light')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('favicon')->nullable();

            // Contact Information
            $table->string('email');
            $table->string('phone');
            $table->string('mobile_number');
            $table->text('address')->nullable();

            // Social Media
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();

            // Default SEO Configuration
            $table->string('default_meta_title');
            $table->text('default_meta_description');
            $table->string('default_og_image')->nullable();

            // Script Injection
            $table->longText('head_script')->nullable();
            $table->longText('body_script')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
