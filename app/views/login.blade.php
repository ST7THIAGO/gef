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
    <title>Document</title>
</head>

<body class="login-body">
    <div class="blur-background-form">
        <div class="form-login-container">
        <h1 class="login-title">Login</h1>
        <form id="login" method="post" class="login-form">
            
            <label class="login-form-label" for="email">E-mail:</label>
            <input class="form-input" type="email" id="e-mail" name="e-mail"/>
            
            <label class="login-form-label" for="senha">Senha:</label>
            <input class="form-input" type="password" id="senha" name="senha"/>

        </form>
    </div>
    <form id="cadastro" method="post" action="cadastro" style="display: none;">
            
            
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome"/>
            
            <label for="e-mail">Email</label>
            <input type="email" id="email" name="email"/>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha"/>

            <label for="telefone">Telefone</label>
            <input type="tel" id="telefone" name="telefone" pattern="[0-9]{2} - [0-9] {4} - [0-9]{4}"/>

            <label for="cpf">Cpf</label>
            <input type="text" id="cpf" name="cpf"/>
            
            <label for="Endereço">Endereço</label>
            <input type="text" id="Endereço" name="endereco"/>
        </form>
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
                <a href="#" id="comprar-botao-descricao">Comprar</a>
                <a href="#" id="ver-mais-botao">Ver mais</a>
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