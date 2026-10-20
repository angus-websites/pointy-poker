<?php

namespace App\Services;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Cache;

class LogoService
{
    private const HALLOWEEN_START_MONTH = 10;
    private const HALLOWEEN_START_DAY = 1;
    private const HALLOWEEN_END_DAY = 31;

    private const CHRISTMAS_START_MONTH = 12;
    private const CHRISTMAS_START_DAY = 1;
    private const CHRISTMAS_END_DAY = 25;

    private const CACHE_KEY = 'app.logo_name';
    private const CACHE_TTL = 3600; // 1 hour

    // Override these in code to test different logos
    public ?bool $forceHalloween = null;
    public ?bool $forceChristmas = null;

    public function getLogoName(): string
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            if ($this->forceHalloween === true) {
                return 'logo-halloween';
            }

            if ($this->forceChristmas === true) {
                return 'logo-christmas';
            }

            $date = now();

            if ($this->isHalloweenSeason($date)) {
                return 'logo-halloween';
            }

            if ($this->isChristmasSeason($date)) {
                return 'logo-christmas';
            }

            return 'logo';
        });
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function isHalloweenSeason(CarbonInterface $date): bool
    {
        return $date->month === self::HALLOWEEN_START_MONTH
            && $date->day >= self::HALLOWEEN_START_DAY
            && $date->day <= self::HALLOWEEN_END_DAY;
    }

    private function isChristmasSeason(CarbonInterface $date): bool
    {
        return $date->month === self::CHRISTMAS_START_MONTH
            && $date->day >= self::CHRISTMAS_START_DAY
            && $date->day <= self::CHRISTMAS_END_DAY;
    }
}

