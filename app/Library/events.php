<?php

use App\Events\CRUDErrorOccurred;
use App\Events\UserLoggedIn;
use App\Events\UserWasCreated;
use App\Listeners\CRUDErrorHasOccurred;
use App\Listeners\UserHasBeenCreated;
use App\Listeners\UserHasLoggedIn;

$events = [
    CRUDErrorOccurred::class => [
        CRUDErrorHasOccurred::class,
    ],

    UserLoggedIn::class => [
        UserHasLoggedIn::class,
    ],

    UserWasCreated::class => [
        UserHasBeenCreated::class,
    ]


];
