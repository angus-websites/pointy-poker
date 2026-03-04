<?php

use Mailjet\LaravelMailjet\MailjetServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    MailjetServiceProvider::class,
];
