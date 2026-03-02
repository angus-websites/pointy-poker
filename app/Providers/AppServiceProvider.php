<?php

namespace App\Providers;

use App\Contracts\Repository\ParticipantRepositoryInterface;
use App\Contracts\Repository\RoomRepositoryInterface;
use App\Contracts\Repository\RoundRepositoryInterface;
use App\Contracts\Repository\VoteRepositoryInterface;
use App\Repositories\Eloquent\EloquentParticipantRepository;
use App\Repositories\Eloquent\EloquentRoomRepository;
use App\Repositories\Eloquent\EloquentRoundRepository;
use App\Repositories\Eloquent\EloquentVoteRepository;
use Carbon\CarbonImmutable;
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

        // Room repository binding
        $this->app->bind(
            RoomRepositoryInterface::class,
            EloquentRoomRepository::class
        );

        // Round repository binding
        $this->app->bind(
            RoundRepositoryInterface::class,
            EloquentRoundRepository::class
        );

        // Participant repository binding
        $this->app->bind(
            ParticipantRepositoryInterface::class,
            EloquentParticipantRepository::class
        );

        // Vote repository binding
        $this->app->bind(
            VoteRepositoryInterface::class,
            EloquentVoteRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
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
