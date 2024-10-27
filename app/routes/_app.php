<?php
app()->get('/', 'HomeController@index');
app()->match('GET|POST', '/users/login', 'UsersController@login');
app()->match('GET|POST', '/users/home', 'UsersController@home');
app()->post('/users/create', 'UsersController@create');
