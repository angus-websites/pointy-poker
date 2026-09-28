<?php

namespace App\Console\Commands;

use App\Services\ApplicationVersionService;
use Illuminate\Console\Command;

class ClearVersionCacheCommand extends Command
{
    protected $signature = 'app:clear-version-cache';

    protected $description = 'Clear the cached application version value';

    /**
     * Execute the console command.
     */
    public function handle(ApplicationVersionService $applicationVersionService): int
    {
        $applicationVersionService->clearComposerVersionCache();

        $this->info('Cleared cache entry ['.ApplicationVersionService::CACHE_KEY.'].');

        return self::SUCCESS;
    }
}
