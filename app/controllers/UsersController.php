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
use \App\Models\Advertiser;
use Faker\Factory as Faker;

/**
 * @property Leaf\Http\Request $request
 * @property App\Services\AuthService\AuthService $authService
 * */
class UsersController extends Controller
{
    protected AuthService $authService;
    private Form $form;

    public function __construct()
    {
        parent::__construct();
        $this->request = new Request;
        // servico de autenticacao de usuarios
        $this->authService = new AuthService;
        $this->form = new Form;
    }

    private function _changeFormValidation(): void
    {
        $this->form->message([
            'username' => 'O {field} deve contar apenas numeros e letras',
            'required' => 'O {field} é o obrigatório',
            'min:8' => 'O campo {field} deve possuir pelo menos 8 caracteres'
        ]);
    }

    public function login()
    {
        $method = $this->request->getMethod();
        $this->_changeFormValidation();

        if ($method == "POST"):

            $isValid = $this->request->validate([
                'e-mail' => 'email',
                'senha' => 'min:8'
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
                $this->form->addError("message", "Senha ou email inválido!");
                return render('login', [
                    'loginErrors' => [json_encode($this->form->errors())],
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
        $this->_changeFormValidation();

        if (is_null($isUserLogged)) {
            DevTools::console("usuário não encontrado em home");
            $this->form->addError('Message', 'Usuário não encontrado!');
            return redirect('/users/login', ['loginErrors' => [json_encode($this->form->errors())]]);
        }

        $method = $this->request->getMethod();

        if ($method == "POST"):
            $isValid = $this->request->validate([
                "anunciante-nome" => "string|max:255",
                "anunciante-email" => "email",
                "anunciante-telefone" => "phone",
                "anunciante-endereco" => "string|max:255"
            ]);

            $faker = Faker::create("pt_BR");
            $cnpj = (string)$faker->cnpj(true);

            if (!$isValid):
                $errors = $this->request->errors();
                return render('home', ['homeErrors' => [json_encode($errors)]]);
            endif;

            $existingAdvertiser = Advertiser::where('corporate_email', $this->request->get("anunciante-email"))->first();

            DevTools::console("usuario existente na base " . json_encode($existingAdvertiser));
            if (isset($existingAdvertiser)):
                $this->form->addError('Message', 'O anunciante já existe');
                return render('home', ['homeErrors' => [json_encode($this->form->errors())]]);
            endif;

            $newAdvertiser = new Advertiser;
            $newAdvertiser->company_name = (string)$this->request->get("anunciante-nome");
            $newAdvertiser->corporate_email = (string)$this->request->get("anunciante-email");
            $newAdvertiser->phone_number = (string)$this->request->get("anunciante-telefone");
            $newAdvertiser->company_address = (string)$this->request->get("anunciante-endereco");
            $newAdvertiser->cnpj = $cnpj;
            $newAdvertiser->user_id = $isUserLogged->id;
            DevTools::console("novo anunciante ". json_encode($newAdvertiser));
            $newAdvertiser->save();
            return render('home');
        endif;

        render('home');
    }

    public function create()
    {
        $this->_changeFormValidation();

        $isValid = $this->request->validate([
            'register-nome' => 'text',
            'register-email' => 'email',
            'register-senha' => 'min:8',
            'register-telefone' => 'phone',
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
            $this->form->addError("message", "usuário já cadastrado!");
            return render('login', [
                'registerErrors' => [json_encode($this->form->errors())],
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
