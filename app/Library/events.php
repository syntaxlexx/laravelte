<?php

use App\Events\CRUDErrorOccurred;
use App\Events\UserLoggedIn;
use App\Listeners\CRUDErrorHasOccurred;
use App\Listeners\UserHasLoggedIn;

$events = [
    CRUDErrorOccurred::class => [
        CRUDErrorHasOccurred::class,
    ],

    UserLoggedIn::class => [
        UserHasLoggedIn::class,
    ]
];
