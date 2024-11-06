<?php

namespace App\Services;


class AuthService
{

    public function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    public function setLoggedUser($user)
    {
        $_SESSION['user'] = $user;
    }

    public function getLoggedUser()
    {
        return $_SESSION['user'];
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }
}
