<?php

namespace App\Providers;

use App\Contracts\RoomRepositoryInterface;
use App\Models\User;
use App\Repositories\RoomRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            RoomRepositoryInterface::class,
            RoomRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        // Guest Cookie guard
        Auth::viaRequest('guest-cookie', function (Request $request) {

            // If user is already authenticated, return the user
            if (Auth::hasUser()) {
                return Auth::user();
            }

            // Check for guest cookie and log in as guest user if it exists
            $cookie = $request->cookie('pokey_guest');

            if ($cookie) {
                Log::info('Logging in guest user from cookie', ['cookie' => $cookie]);
                $guest = json_decode(decrypt($cookie), true);
                return User::factory()->make([
                    'id' => $guest['id'],
                    'name' => $guest['name'],
                ]);
            }

            return null;
        });
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
