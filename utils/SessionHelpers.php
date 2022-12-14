<?php


namespace utils;


class SessionHelpers
{
    public function __construct()
    {
        SessionHelpers::init();
    }

    static function init(): void
    {
        session_start();
    }

    static function login($equipe): void
    {
        $_SESSION['LOGIN'] = $equipe;
    }

    static function logout(): void
    {
        unset($_SESSION['LOGIN']);
    }

    static function logOutApi(): void
    {
        unset($_SESSION["admin"]);
    }

    static function getConnected()
    {
        if (SessionHelpers::isLogin()) {
            return $_SESSION['LOGIN'];
        } else {
            return array();
        }
    }

    static function isLogin(): bool
    {
        return isset($_SESSION['LOGIN']);
    }
}