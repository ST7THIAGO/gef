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
        <form id="login" method="post" class="login-form">
            <?php Leaf\Anchor\CSRF::form(); ?>

            <label class="login-form-label" for="email">E-mail:</label>
            <input class="form-input" type="email" id="e-mail" name="e-mail"/>

            <label class="login-form-label" for="senha">Senha:</label>
            <input class="form-input" type="password" id="senha" name="senha"/>

            <div class="button-container">
                <input type="button" value="Entrar" class="login-button"/>
            </div>

            <div class="register-question">
                Ainda não possui conta? <span class="register-user" onclick="switchForms()">CRIAR</span>
            </div>

        </form>
    </div>
        <div class="form-register-container" style="display: none;">
        <span class="close-blur" onclick="closeBlur()">X</span>

        <form id="cadastro" method="post" action="/users/create">

            <?php Leaf\Anchor\CSRF::form(); ?>

            <label for="register-nome">Nome</label>
            <input type="text" name="register-nome" id="register-nome"/>

            <label for="register-email">Email</label>
            <input type="email" id="register-email" name="register-email"/>

            <label for="register-senha">Senha</label>
            <input type="password" id="register-senha" name="register-senha"/>

            <label for="register-telefone">Telefone</label>
            <input type="tel" id="telefone" name="register-telefone" pattern="[0-9]{2} - [0-9] {4} - [0-9]{4}"/>

            <label for="register-cpf">Cpf</label>
            <input type="text" id="register-cpf" name="register-cpf"/>

            <label for="register-endereco">Endereço</label>
            <input type="text" id="register-endereco" name="register-endereco"/>

            <div class="register-question">
                Já possui conta? <span class="register-user" onclick="switchForms()">Logar</span>
            </div>

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

        <?php
            if ($errors && count($errors) > 0 ):
                foreach($errors as $error):
                    echo "<span class='error'>". $error ."</span>";
                endforeach;
            endif;

            if ($success):
                echo "<span class='success'></span>";
            endif;
        ?>


</body>

</html>
