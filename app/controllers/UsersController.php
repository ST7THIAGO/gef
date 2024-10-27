<?php

namespace App\Controllers;

use Leaf\Http\Request;

use \App\Services\AuthService;

/**
 * @property Leaf\Http\Request $request
 * @property App\Services\AuthService\AuthService $authService
 * */
class UsersController extends Controller
{
    protected AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->request = new Request;
        // servico de autenticacao de usuarios
        $this->authService = new AuthService;
    }

    public function login()
    {
        // chama a página de login
        render('login', ['errors' => [], 'success' => true]);
    }

    public function home()
    {
        // checa se o usuário está logado antes de direcionar
        // para home
        if (!$this->authService->isUserLoggedIn()) {
            return $this->authService->redirectTo('/users/login/');
        }

        return render('home', ['errors' => [], 'success' => true]);
    }

    public function create()
    {
        // TODO - tratar a criação do usuário aqui
        // 1 - receber requisição
        // 2 - fazer validações
        // 3 - chamar o model
        // 4 - registar o usuario no banco de dados
        // 5 - setar a variavel $_SESSION['user']
        // 6 - redirecionar o usuário para a tela home

        return render('login', ['errors' => [], 'success' => true]);
    }
}
