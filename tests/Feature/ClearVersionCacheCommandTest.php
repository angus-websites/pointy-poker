<?php

use App\Services\ApplicationVersionService;
use Illuminate\Support\Facades\Cache;

test('clear version cache command removes the cached application version entry', function () {
    Cache::put(ApplicationVersionService::CACHE_KEY, 'stale-version', now()->addMinutes(5));

    expect(Cache::has(ApplicationVersionService::CACHE_KEY))->toBeTrue();

    $this->artisan('app:clear-version-cache')
        ->assertSuccessful()
        ->expectsOutputToContain('Cleared cache entry [app.version].');

    expect(Cache::has(ApplicationVersionService::CACHE_KEY))->toBeFalse();
});
