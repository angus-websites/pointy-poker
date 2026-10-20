<?php

use App\Services\LogoService;
use Carbon\Carbon;

test('logo service returns default logo for normal dates', function () {
    Carbon::setTestNow('2026-06-15');
    
    $service = app(LogoService::class);
    $logo = $service->getLogoName();
    
    expect($logo)->toBe('logo');
    
    Carbon::setTestNow(null);
});

test('logo service returns halloween logo during october', function () {
    Carbon::setTestNow('2026-10-15');
    
    $service = app(LogoService::class);
    $logo = $service->getLogoName();
    
    expect($logo)->toBe('logo-halloween');
    
    Carbon::setTestNow(null);
});

test('logo service returns christmas logo during december 1-25', function () {
    Carbon::setTestNow('2026-12-10');
    
    $service = app(LogoService::class);
    $logo = $service->getLogoName();
    
    expect($logo)->toBe('logo-christmas');
    
    Carbon::setTestNow(null);
});

test('logo service returns default logo after christmas', function () {
    Carbon::setTestNow('2026-12-26');
    
    $service = app(LogoService::class);
    $logo = $service->getLogoName();
    
    expect($logo)->toBe('logo');
    
    Carbon::setTestNow(null);
});

test('logo service can be forced to halloween', function () {
    $service = app(LogoService::class);
    $service->forceHalloween = true;
    $service->clearCache();
    
    $logo = $service->getLogoName();
    
    expect($logo)->toBe('logo-halloween');
});

test('logo service can be forced to christmas', function () {
    $service = app(LogoService::class);
    $service->forceChristmas = true;
    $service->clearCache();
    
    $logo = $service->getLogoName();
    
    expect($logo)->toBe('logo-christmas');
});
