<?php

namespace App\Middleware;

use Leaf\Middleware;
use Leaf\Http\Request;
use Leaf\Http\Response;
use Leaf\DevTools;

use App\Services\AuthService;

/**
 * */
class AuthMiddleware extends Middleware
{
    public function call()
    {
        $req = new Request;
        $resp = new Response;

        $service = new AuthService;

        $info = $req->getPathInfo();

        DevTools::console('path ' . $info);

        $test = $service->isUserLoggedIn();

        $resp->next($test);
    }
}
