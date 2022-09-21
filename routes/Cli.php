<?php

namespace routes;

use cli\Internal;
use routes\base\Route;

class Cli
{
    private Internal $internal;

    function __construct()
    {
        $this->internal = new Internal();
        Route::Add('serve', [$this->internal, 'serve']);
        Route::Add('db:migrate', [$this->internal, 'dbMigrate']);
        Route::Add('controller:create', [$this->internal, 'createController']);
        Route::Add('model:create', [$this->internal, 'createModel']);
    }
}

