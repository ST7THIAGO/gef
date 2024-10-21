<?php

app()->get('/', 'HomeController@index');
app()->get('/users/login', 'UsersController@login');

app()->post('/users/login', function() {
    render('index', ['errors' => ['o anunciante ja existe!'], 'success' => false]);
});
