<?php

namespace App\Services;


class AuthService
{

    public function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    public function redirectTo(string $path)
    {
        return redirect($path);
    }
}
