<?php

app()->get('/', function () {
    /**
     * `render(view, [])` is the same as `echo view(view, [])`
     */
    render('index',['errors'=> [], 'success' => false]);
});

app()->post('/', function() {
    render('index', ['errors' => ['o anunciante ja existe!'], 'success' => false]);
});
