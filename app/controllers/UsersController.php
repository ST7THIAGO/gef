<?php

namespace App\Controllers;

use Leaf\Http\Request;
use \App\Services\AuthService;
use Leaf\DevTools;
use Leaf\Form;
use Leaf\Helpers\Password;
use \App\Models\User;
use DateTime;
use Exception;
use Leaf\Auth;
use Leaf\Http\Response;
use \App\Models\Advertiser;
use Faker\Provider\pt_BR\Company;
use Faker\Factory as Faker;

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

            if (!$isValid):
                $errors = $this->request->errors();
                return render('login', ['loginErrors' => [json_encode($errors)]]);
            endif;

            $email = $this->request->get("e-mail");
            $password = $this->request->get("senha");

            $user = User::where('email', $email)->first();

            $isPasswordValid = Password::verify($password, $user->password);

            if (!$user || !$isPasswordValid):
                Form::addError("message", "Senha ou email inválido!");
                return render('login', [
                    'loginErrors' => [json_encode(Form::errors())],
                ]);
            endif;

            $user->password = $password;
            $this->authService->login($user);
            $this->authService->setLoggedUser($user);
            return render('home');
        endif;

        // chama a página de login no method get
        return render('login', ['loginErrors' => []]);
    }

    public function home()
    {
        // checa se o usuário está logado antes de direcionar
        // para home (checagem feita em middleware/AuthMiddleware)
        $isUserLogged = $this->authService->getUser();
        
        if (is_null($isUserLogged)) {
            DevTools::console("usuário não encontrado");
            Form::addError('Message', 'Usuário não encontrado!');
            return redirect('/users/login', ['loginErrors' => [json_encode(Form::errors())]]);
        }
        
        DevTools::console($isUserLogged);

        $method = $this->request->getMethod();

        DevTools::console("Metodo ". $method);

        if ($method == "POST"):
            DevTools::console("caiu no post");
            $isValid = $this->request->validate([
                "nome" => "text|required",
                "email" => "email|required",
                "telefone" => "required",
                "endereco" => "text|required"
            ]);

            $faker = Faker::create();
            $cnpj = $faker->firstname;
            
            DevTools::console("cnpj ".$cnpj);

            DevTools::console("form valido? ". $isValid ? "sim" : "nao");
            DevTools::console("user_id ". $isUserLogged["id"]);

            if (!$isValid):
                $errors = $this->request->errors();
                return render('home', ['homeErrors' => [json_encode($errors)]]);
            endif;
            
            $existingAdvertiser = Advertiser::where('email', $this->request->get("email"))->first();

            if ($existingAdvertiser):
                Form::addError('Message', 'O anunciante já existe');    
                return render('home', ['homeErrors' => [json_encode(Form::errors())]]);
            endif;

            $newAdvertiser = new Advertiser;

            $newAdvertiser->company_name = $this->request->get("nome");
            $newAdvertiser->corporate_email = $this->request->get("email");
            $newAdvertiser->phone_number = $this->request->get("telefone");
            $newAdvertiser->company_address = $this->request->get("endereco");
            $newAdvertiser->cnpj = $cnpj;
            $newAdvertiser->user_id = $isUserLogged->id;
            $newAdvertiser->save();
            return render('home');
        endif;

        render('home');
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
            $this->authService->login($user);
            $this->authService->setLoggedUser($user);
            return redirect('/users/home', ['homeErrors' => []]);
        endif;

        return render('login', ['loginErrors' => []]);
    }

    public function logout()
    {
        try {
            $this->authService->logout();
            return redirect('/users/login', ['loginErrors' => []]);
        } catch (Exception $e) {
            DevTools::console("Erro " . json_encode($e));
            return null;
        }
    }
}
