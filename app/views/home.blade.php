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

<body>
    <header>
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
    <div class="carrosel">
        <div class="card-carrosel">
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
        </div>
        <a href="#anunciante">Anunciar</a>
    </div>
    <div class="sinopse">
        <div class="esquerda-sinopse">
            <img src="{{ assets('img/EBOOK.png')}}" alt="Sinopse">
        </div>
        <div class="direita-sinopse">
            <h1>Sinopse</h1>
            <p>"Gemologia em Foco: A Arte de Lapidar-se" não é apenas um guia sobre pedras preciosas, é um manual para
                você lapidar a si mesmo. Nele, você encontrará lições motivacionais, utilizando a gemologia como
                metáfora para o autodesenvolvimento, e os ensinamentos de Musashi Miyamoto para reforçar que, assim como
                uma pedra bruta pode se tornar uma joia rara, você também pode se transformar em sua melhor versão.
                Seja você um apaixonado por gemas ou alguém em busca de motivação e crescimento pessoal, "A Arte de
                Lapidar-se" mostrará como transformar as pressões diárias em oportunidades.</p>
            <div class="comprar-sinopse">
                <a href="#" id="comprar-sinopse">Comprar</a>
            </div>
        </div>
    </div>
    <div class="ser-anunciante" id="anunciante">        
        <form id="form-anunciante" method="post" action="/">
            <?php Leaf\Anchor\CSRF::form(); ?>

            <div class="card">
                <div class="titulo-anunciante">
                    <h1>Ser Anunciante</h1>
                </div>
            
                <div class="textfield">
                    <div class="dados">
                        <label for="nome">Nome:</label>
                        <input type="text" name="name">
                    </div>
                    <div class="dados">
                    <label for="nome">Email:</label>
                    <input type="email" name="e-mail">
                </div>
                <div class="dados">
                    <label for="nome">Telefone:</label>
                    <input type="text">
                </div>
                <div class="dados">
                    <label for="nome">Endereço:</label>
                    <input type="text">
                </div>
            </div>
            <div class="enviar-anunciante">
                <a href="#">Enviar</a>
            </div>
        </div>
    </form>
    </div>
    <div class="quem-somos" id="somos">
        <h1>QUEM SOMOS?</h1>
        <p>Na Gemologia em Foco, acreditamos que a verdadeira beleza e o valor de uma joia estão no seu processo de
            lapidação, assim como o potencial de cada pessoa é revelado através do autoconhecimento e da disciplina.
            <br>
            <br>
            Nosso propósito é mais do que compartilhar conhecimentos sobre gemas preciosas, queremos oferecer uma nova
            perspectiva sobre autossuperação.
            <br>
            <br>
            Assim como uma pedra bruta se torna uma joia valiosa, você também pode lapidar seu caminho rumo ao sucesso,
            guiado pelos ensinamentos do lendário samurai Musashi Miyamoto e pelas lições de vida que ressoam
            profundamente no processo de crescimento pessoal retratados no mangá Vagabond.
            <br>
            <br>
            Com a união de nosso conhecimento técnico e uma visão inspiradora, nosso time é capaz de oferecer uma
            jornada transformadora para quem busca conhecimento, crescimento pessoal e profissional.</p>
    </div>
    <footer>
        <span>© 2024 | Gemologia em Foco</span>
        <span>Fale conosco (yy)xxxxx-xxxx</span>
    </footer>
</body>

</html>