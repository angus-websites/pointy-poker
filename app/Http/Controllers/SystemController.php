<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * The SystemController handles system-related endpoints such as version and info.
 */
class SystemController extends Controller
{
    public function version(): JsonResponse
    {
        return response()->json([
            'app' => config('app.name'),
            'version' => $this->composerVersion(),
        ]);
    }

    /**
     * Show system information
     */
    public function info(Request $request): JsonResponse|View
    {
        $data = [
            'app' => config('app.name'),
            'version' => $this->composerVersion(),
            'environment' => config('app.env'),
            'status' => app()->isDownForMaintenance() ? 'Maintenance' : 'Healthy',
        ];

        // Return JSON response if requested
        if ($request->expectsJson()) {
            return response()->json($data);
        }

        // Otherwise, return a view
        return view('public.system.info', compact('data'));
    }

    /**
     * Get the application version from composer.json
     */
    protected function composerVersion(): string
    {
        return Cache::remember('app.version', now()->addMinutes(5), function () {
            $composer = json_decode(
                file_get_contents(base_path('composer.json')),
                true
            );

            return $composer['version'] ?? 'unknown';
        });
    }
}
