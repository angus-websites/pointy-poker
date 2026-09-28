<?php

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use Mailjet\LaravelMailjet\MailjetServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    MailjetServiceProvider::class,
];
