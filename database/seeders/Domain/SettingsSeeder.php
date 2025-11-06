<?php

namespace Database\Seeders\Domain;

use App\Support\Settings\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            [
                'key' => 'site_name',
                'value' => 'Agency Starter Kit',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Name',
                'order' => 1,
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Your Perfect Starting Point',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Tagline',
                'order' => 2,
            ],
            [
                'key' => 'site_description',
                'value' => 'A professional starter kit for web agencies',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Description',
                'order' => 3,
            ],
            // SEO
            [
                'key' => 'meta_title_default',
                'value' => 'Agency Starter Kit - Professional Web Solutions',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Default Meta Title',
                'order' => 1,
            ],
            [
                'key' => 'meta_description_default',
                'value' => 'Professional starter kit for web development agencies',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Default Meta Description',
                'order' => 2,
            ],
            // Contact
            [
                'key' => 'contact_email',
                'value' => 'contact@starter.local',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Contact Email',
                'order' => 1,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Contact Phone',
                'order' => 2,
            ],
            // Social
            [
                'key' => 'facebook_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Facebook URL',
                'order' => 1,
            ],
            [
                'key' => 'twitter_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Twitter URL',
                'order' => 2,
            ],
            [
                'key' => 'instagram_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Instagram URL',
                'order' => 3,
            ],
            [
                'key' => 'linkedin_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'order' => 4,
            ],
        ];
        foreach ($settings as $setting) {
            Setting::create($setting);
        }

    }
}
