<?php

namespace controllers\base;

class WebController implements IBase
{

    function redirect($to): void
    {
        header("Location: $to");
        die();
    }
}