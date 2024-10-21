<?php

namespace App\Controllers;

use Leaf\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $parent::__construct();
        $this->request = new Request;
    }

  public function login()
    {

        render('index', ['errors' => [], 'success' => true]);
    }
    
}
