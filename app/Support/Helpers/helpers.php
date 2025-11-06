<?php

use App\Support\Features\FeatureManager;
use App\Support\Settings\SettingsService;

if (! function_exists('settings')) {
    /**
     * Get a setting value or all settings.
     *
     * @param  mixed  $default
     * @return mixed
     */
    function settings(?string $key = null, $default = null)
    {
        $service = app(SettingsService::class);
        if ($key === null) {
            return $service->all();
        }

        return $service->get($key, $default);
    }
}
if (! function_exists('feature')) {
    /**
     * Check if a feature is enabled.
     *
     * @param  string  $feature*  @return bool
     */
    function feature(string $feature): bool
    {
        return app(FeatureManager::class)->isEnabled($feature);
    }
}
if (! function_exists('features')) {
    /**
     * Get all features status.
     */
    function features(): array
    {
        return app(FeatureManager::class)->all();
    }
}
if (! function_exists('format_file_size')) {
    /**
     * Format bytes to human readable file size.
     */
    function format_file_size(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision).' '.$units[$i];
    }
}
if (! function_exists('truncate_text')) {
    /**
     * Truncate text to a specified length.
     */
    function truncate_text(string $text, int $length = 100, string $suffix = '...'): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }

        return mb_substr($text, 0, $length).$suffix;
    }
}
if (! function_exists('starter_version')) {
    /**
     * Get the starter kit version.
     */
    function starter_version(): string
    {
        return config('starter.version', '1.0.0');

    }
}
