<?php

namespace App\Providers;

use App\Contracts\RoomRepositoryInterface;
use App\Repositories\RoomRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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
            $cookie = $request->cookie('pokey_guest');
            if ($cookie) {
                $guest = json_decode(decrypt($cookie), true);

                return (object) [
                    'id' => $guest['id'],
                    'name' => $guest['name'],
                    'admin' => false,
                ];
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
