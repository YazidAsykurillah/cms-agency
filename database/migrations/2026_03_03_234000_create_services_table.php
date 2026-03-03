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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('full_description');
            $table->string('featured_image');
            $table->string('icon')->nullable();
            
            // Strategic fields
            $table->longText('problem_statement')->nullable();
            $table->longText('solution_approach')->nullable();
            $table->json('process_steps')->nullable();
            $table->json('faq')->nullable();
            $table->string('call_to_action_text')->nullable();
            
            $table->boolean('featured')->default(false);
            
            // SEO Fields
            $table->string('seo_title');
            $table->text('seo_description');
            $table->string('seo_keywords')->nullable();
            $table->string('og_image')->nullable();
            
            $table->enum('status', ['draft', 'published'])->default('draft');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
