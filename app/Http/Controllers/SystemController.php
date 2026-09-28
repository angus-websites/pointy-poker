<?php

namespace App\Http\Controllers;

use App\Services\ApplicationVersionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * The SystemController handles system-related endpoints such as version and info.
 */
class SystemController extends Controller
{
    public function __construct(
        protected ApplicationVersionService $applicationVersionService,
    )
    {
    }

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
        return $this->applicationVersionService->composerVersion();
    }
}
