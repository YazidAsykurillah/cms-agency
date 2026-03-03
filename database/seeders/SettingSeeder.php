<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = Setting::getSettings();

        $settings->update([
            'agency_name' => 'Nano Banana',
            'tagline' => 'Small Scale, Massive Impact.',
            'description' => 'We are a premier digital agency specializing in high-performance web systems and minimalist design. We build scaleable digital experiences for modern brands.',
            'email' => 'hello@nanobanana.com',
            'phone' => '+1 (555) 123-4567',
            'mobile_number' => '+1 (555) 987-6543',
            'address' => "123 Innovation Drive\nTech District\nSilicon Valley, CA 94025",
            'instagram_url' => 'https://instagram.com/nanobanana',
            'linkedin_url' => 'https://linkedin.com/company/nanobanana',
            'youtube_url' => 'https://youtube.com/@nanobanana',
            'tiktok_url' => 'https://tiktok.com/@nanobanana',
            'default_meta_title' => 'Nano Banana - Digital Vanguard',
            'default_meta_description' => 'The leading digital agency for small scale massive impact web applications.',
            
            // Paths to the AI-generated media copied into the storage/app/public directory
            'logo_light' => 'logo_light.png',
            'logo_dark' => 'logo_dark.png',
            'favicon' => 'favicon.png',
            'default_og_image' => 'default_og_image.png',
        ]);
        
        $this->command->info("Nano Banana settings seeded successfully!");
    }
}
