<?php

namespace App\Controllers;

use Leaf\Http\Request;
use \App\Services\AuthService;
use Leaf\DevTools;
use Leaf\Form;
use Leaf\Helpers\Password;
use \App\Models\User;
use DateTime;

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
        // para home (checagem feita em middleware/AuthMiddleware)
        $isUserLogged = $this->request->next();

        if (!$isUserLogged) {
            return redirect('/users/login');
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

        Form::message([
            'username' => 'O {field} deve contar apenas numeros e letras',
            'required' => 'O {field} é o obrigatório',
            'min:8' => 'O campo {field} deve possuir pelo menos 8 caracteres'
        ]);

        $isValid = $this->request->validate([
            'register-nome' => 'text|required',
            'register-email' => 'email|required',
            'register-senha' => 'min:8',
            'register-telefone' => 'required',
            'register-cpf' => 'required',
            'register-endereco' => 'required'
        ]);

        DevTools::console("form valido " . json_encode($isValid));

        if (!$isValid):
            $errors = $this->request->errors();

            if ($errors):
                foreach ($errors as $key => $message):
                    $errors[$key] = str_replace('register-', '', $message);
                endforeach;
            endif;
            return render('login', ['errors' => [json_encode($errors)], 'success' => false]);
        endif;

        $user = new User;

        $existingUser = User::where('email', $this->request->get('register-email'))->first();

        if ($existingUser):
            DevTools::console("usuario ja existe no banco de dados");
            Form::addError("message", "usuário já cadastrado!");
            return render('login', [
                'errors' => [json_encode(Form::errors())],
                'success' => false
            ]);

        endif;

        $user->fullname = $this->request->get('register-nome');
        $user->email = $this->request->get('register-email');
        $user->password = Password::hash($this->request->get('register-senha'), Password::BCRYPT);
        $user->cpf = $this->request->get('register-cpf');
        $user->address = $this->request->get('register-endereco');
        $user->phone_number = $this->request->get('register-telefone');
        $user->email_verified_at = new DateTime;
        $user->save();

        if ($user):
            $this->authService->setLoggedUser($user);
            return redirect('/users/home', ['errors' => [], 'success' => true]);
        endif;


        return render('login', ['errors' => [], 'success' => true]);
    }
}
