<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="{{ assets('js/jquery.js')}}"></script>
    <script src="{{ assets('js/parsley.js')}}"></script>
    <script src="{{ assets('js/ptbr.js')}}"></script>
    <link rel="stylesheet" href="{{ assets('css/style.css') }}">
    <script type="text/javascript" src="{{ assets('js/app.js') }}"></script>

    <title>Login/Create</title>
</head>

<body class="login-body">

    <noscript>
        <span class="no-script">O javascript em seu navegador está desabilitado ou não há suporte!</span>
    </noscript>

    <div class="blur-background-form">
        <div class="form-login-container">
        <h1 class="login-title">Login</h1>
        <span class="close-blur" onclick="closeBlur()">X</span>
        <form id="login" method="post" class="login-form" onsubmit="handleLogin(event);">
            <?php Leaf\Anchor\CSRF::form(); ?>

            <label class="login-form-label" for="email">E-mail:</label>
            <input class="form-input" type="email" id="e-mail" name="e-mail" data-parsley-type="email" data-parsley-required="true"/>

            <label class="login-form-label" for="senha">Senha:</label>
            <input class="form-input" type="password" id="senha" name="senha" data-parsley-required="true" data-parsley-minlength="8" data-parsley-type="alphanum" />

            <div class="button-container" onclick="$('#login').submit();">
                <input type="submit" value="Entrar" class="login-button"/>
            </div>

            <div class="register-question">
                Ainda não possui conta? <span class="register-user" onclick="switchForms()">CRIAR</span>
            </div>

             <?php

                if (isset($loginErrors) && is_iterable($loginErrors)):
                    foreach($loginErrors as $err):
                        if (isset($err)):
                            $errors = json_decode($err);
                            foreach($errors as $msg):
                                echo "<li class='parsley-error'>" . $msg[0] ."</li>";
                            endforeach;
                        endif;
                    endforeach;
                endif;               
            ?>

        </form>
    </div>
        <div class="form-register-container" style="display: none;">
        <span class="close-blur" onclick="closeBlur()">X</span>

         <h1 class="login-title">CRIANDO UMA CONTA</h1>
        <form id="cadastro" method="post" action="/users/create" onsubmit="onRegisterUser(event);">

            <?php Leaf\Anchor\CSRF::form(); ?>

            <label class="login-form-label" for="register-nome">Nome</label>
            <input class="form-input" type="text" name="register-nome" id="register-nome" data-parsley-required="true" data-parsley-length="[5, 200]"/>

            <label class="login-form-label" for="register-email">Email</label>
            <input class="form-input" type="email" data-parsley-type="email" id="register-email" name="register-email" required="true"/>

            <label class="login-form-label"  for="register-senha">Senha</label>
            <input class="form-input"  type="password" id="register-senha" name="register-senha" data-parsley-minlength="8" required="true"/>

            <label class="login-form-label" for="register-telefone">Telefone</label>
            <input class="form-input" type="tel" id="telefone" name="register-telefone" data-parsley-type="digits" required="true"/>

            <label class="login-form-label"  for="register-cpf">Cpf</label>
            <input class="form-input"  type="text" id="register-cpf" name="register-cpf" required="true" data-parsley-minlength="11"/>

            <label class="login-form-label" for="register-endereco">Endereço</label>
            <input class="form-input" type="text" id="register-endereco" name="register-endereco" required="true" data-parsley-length="[4, 200]" />

            <div class="button-container" style="margin-bottom: 8px;" onclick="$('#cadastro').submit();">
                <input type="submit" value="CRIAR CONTA" class="login-button"/>
            </div>

            <div class="register-question" style="margin-bottom: 12px;">
                Já possui conta? <span class="register-user" onclick="switchForms()">Logar</span>
            </div>

              <?php

                if (isset($registerErrors) && is_iterable($registerErrors)):
                    foreach($registerErrors as $err):
                        if (isset($err)):
                            $errors = json_decode($err);
                            foreach($errors as $msg):
                                echo "<li class='parsley-error'>" . $msg[0] ."</li>";
                            endforeach;
                        endif;
                    endforeach;
                endif;           
            ?>

        </form>

        </div>
    </div>
    <header class="login-header">
        <a><img src="{{ assets('img/Logo.png') }}" alt="diamante" class="login-logo"/></a>
        <a href="#">INÍCIO</a>
        <a href="#anunciante">SEJA ANUNCIANTE</a>
        <a href="#somos">QUEM SOMOS</a>
    </header>
    <div class="descricao">
        <div class="esquerda-descricao">
            <h1>GEMOLOGIA EM FOCO:</h1><span> A ARTE DE LAPIDAR-SE </span>
            <div class="botoes">
                <a href="#" id="comprar-botao-descricao" onclick="enableBlur()">Comprar</a>
                <a href="#" id="ver-mais-botao" onclick="enableBlur()">Ver mais</a>
            </div>
        </div>
        <div class="direita-descricao">
            <img src="{{ assets('img/EBOOK.png')}}" alt="Capa">
        </div>
    </div>



</body>

</html>
