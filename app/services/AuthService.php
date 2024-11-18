<?php

namespace App\Services;

use App\Models\User;

class AuthService
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE):
            auth()->config('session', true);
            session()->start();
        endif;
    }

    public function isUserLoggedIn(): bool
    {
        return session()->has('user');
    }

    public function setLoggedUser($user)
    {
        session()->set('user', $user);
    }

    public function getLoggedUser()
    {
        if (session()->has('user')):
            return session()->get('user');
        else:
            return null;
        endif;
    }

    public function logout()
    {
        if (session()->has('user')):
            session()->unset('user');            
            auth()->logout();
            session()->destroy();
        endif;

        if (isset($_SESSION['user'])):
            unset($_SESSION['user']);
        endif;
        
        session()->set('user', null);
        session_destroy();
        header('Location: /users/login'); 
        exit();
    }

    public function login($user): bool
    {
        return auth()->login([
            'email' => $user->email,
            'password' => $user->password
        ]);
    }

    public function getUser()
    {
        return auth()->user();
    }
}
