<?php


app()->get('/', 'HomeController@index');
app()->match('GET|POST', '/users/login', 'UsersController@login');
app()->post('/users/logout', 'UsersController@logout');
app()->match('GET|POST', '/users/home', ['middleware' => 'App\Middleware\AuthMiddleware@call', 'UsersController@home']);
app()->post('/users/create', ['middleware' => 'App\Middleware\AuthMiddleware@call', 'UsersController@create']);
