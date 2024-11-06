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

        Form::message([
            'username' => 'O {field} deve contar apenas numeros e letras',
            'required' => 'O {field} é o obrigatório',
            'min:8' => 'O campo {field} deve possuir pelo menos 8 caracteres'
        ]);

        // servico de autenticacao de usuarios
        $this->authService = new AuthService;

    }

    public function login()
    {
        $method = $this->request->getMethod();

        if ($method == "POST"):
            
            $isValid = $this->request->validate([
                'e-mail' => 'email|required',
                'senha' => 'min:8|required'
            ]);

            DevTools::console("login valido? " . json_encode($isValid));

            if (!$isValid): 
                $errors = $this->request->errors();            
                return render('login', ['loginErrors' => [json_encode($errors)]]);
            endif;
            
            $email = $this->request->get("e-mail");
            $password = $this->request->get("senha");

            DevTools::console($email);
            DevTools::console($password);

            $user = User::where('email', $email)->first();

            DevTools::console('usuário encontrado? ', $user ? 'sim' : 'não');

            if (!$user):
                Form::addError("message", "Senha ou email inválido!");
                return render('login', [
                    'loginErrors' => [json_encode(Form::errors())],                    
                ]);
            endif;
            
            $this->authService->setLoggedUser($user);

            DevTools::console('usuário logado? ' . $this->authService->getLoggedUser() ? 'sim' : 'não');

            return render('home', ['homeErrors' => []]);
        endif;

        // chama a página de login
        render('login', ['loginErrors' => []]);
    }

    public function home()
    {
        // checa se o usuário está logado antes de direcionar
        // para home (checagem feita em middleware/AuthMiddleware)
        $isUserLogged = $this->request->next();
        $isUserSetted = $this->authService->getLoggedUser();

        if (!$isUserLogged && !$isUserSetted) {
            return redirect('/users/login', ['loginErrors' => []]);
        }

        return render('home', ['homeErrors' => [], 'success' => true]);
    }

    public function create()
    {
       

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
            return render('login', ['registerErrors' => [json_encode($errors)]]);
        endif;

        $user = new User;

        $existingUser = User::where('email', $this->request->get('register-email'))->first();

        if ($existingUser):
            DevTools::console("usuario ja existe no banco de dados");
            Form::addError("message", "usuário já cadastrado!");
            return render('login', [
                'registerErrors' => [json_encode(Form::errors())],                
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
            return redirect('/users/home', ['homeErrors' => []]);
        endif;


        return render('login', ['loginErrors' => []]);
    }
}
