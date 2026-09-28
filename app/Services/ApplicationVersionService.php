<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Service class to manage application version information.
 */
class ApplicationVersionService
{
    public const string CACHE_KEY = 'app.version';

    public function composerVersion(): string
    {
        return Cache::remember(self::CACHE_KEY, now()->addMinutes(5), function (): string {
            $composer = json_decode(
                file_get_contents(base_path('composer.json')),
                true
            );

            return $composer['version'] ?? 'unknown';
        });
    }

    public function clearComposerVersionCache(): bool
    {
        return Cache::forget(self::CACHE_KEY);
    }
}
