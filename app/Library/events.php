<?php

use App\Events\CRUDErrorOccurred;
use App\Listeners\CRUDErrorHasOccurred;

$events = [
    CRUDErrorOccurred::class => [
        CRUDErrorHasOccurred::class,
    ],
];
