<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
       redirect('/users/login');
    }
}
