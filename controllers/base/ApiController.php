<?php

namespace controllers\base;

class ApiController implements IBase
{

    function redirect($to)
    {
        header("Location: $to");
        die();
    }
}