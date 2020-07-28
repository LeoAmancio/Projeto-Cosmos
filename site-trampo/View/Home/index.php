<?php
    require "../../Dao/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Trampo</title>
</head>

<body>
    <header>
        <span>
            <img src="img/logo/trampo_logo_normal.png" alt="trampo logo" width="100" class="normal-logo">
            <img src="img/logo/trampo_logo_white.png" alt="trampo logo" width="100" class="white-logo">
        </span>

        <input type="checkbox" id="toggle">
        <label for="toggle" class="navbar-icon"><img src="img/icon/navbar-icon.svg" alt="navbar icon"></label>
        <nav class="menu">
            <a href="../TelaLogin/">Entrar</a>
            <a href="../UserRegister/">Cadastrar-se</a>
        </nav>
    </header>

    <section class="home">
        <img src="img/background/home-mobile-background.png" draggable="false" class="home-mobile-background">
        <img src="img/background/home-desktop-background.png" draggable="false"
            class="home-desktop-background show-desktop">
        <div class="home-wrapper">
            <h1>Precisando de um serviço?</h1>
            <h2>Aqui você encontra a pessoa certa</h2>
            <form action="#">
                <input type="search" placeholder="Digite o que precisa" id="search-bar">
                <button type="submit">Buscar <img src="img/icon/magnifying-glass-white.svg"></button>
                <img src="img/icon/magnifying-glass-black.svg" alt="search icon" class="search-icon show-tablet">
                <div id="search-result" class="search">
                    <?php
                        $query = mysqli_query($conn, "SELECT id, name FROM occupation_subcategory");
                        while($row = mysqli_fetch_assoc($query)) {
                            echo "<a href='../TelaLogin'>".$row['name']."</a> ";
                        }
                    ?>
                    <a href="#">Resultado</a>
                    <a href="#">Resultado</a>
                    <a href="#">Resultado</a>
                </div>
            </form>
            <div class="satisfaction show-tablet">
                <img src="img/icon/five-stars-icon.svg" alt="five stars icons" class="stars-icon">
                <h2>Satisfação garantida</h2>
            </div>
            <div class="home-services-icons show-tablet">
                <div class="service-icon show-desktop">
                    <a href="../TelaLogin"><img src="img/icon/graduation-cap.svg" alt="home icon">
                        <h2>Aulas</h2>
                    </a>
                </div>
                <div class="service-icon">
                    <a href="../TelaLogin"><img src="img/icon/spray-bottle.svg" alt="home icon">
                        <h2>Beleza</h2>
                    </a>
                </div>
                <div class="service-icon show-desktop">
                    <a href="../TelaLogin"><img src="img/icon/delivery-truck.svg" alt="home icon">
                        <h2>Carretos</h2>
                    </a>
                </div>
                <div class="service-icon show-desktop">
                    <a href="../TelaLogin"><img src="img/icon/cake.svg" alt="home icon">
                        <h2>Doces</h2>
                    </a>
                </div>
                <div class="service-icon show-desktop">
                    <a href="../TelaLogin"><img src="img/icon/pencil.svg" alt="home icon">
                        <h2>Escrita</h2>
                    </a>
                </div>
                <div class="service-icon">
                    <a href="../TelaLogin"><img src="img/icon/farming-and-gardening.svg" alt="home icon">
                        <h2>Jardim</h2>
                    </a>
                </div>
                <div class="service-icon show-desktop">
                    <a href="../TelaLogin"><img src="img/icon/cello.svg" alt="home icon">
                        <h2>Músico</h2>
                    </a>
                </div>
                <div class="service-icon">
                    <a href="../TelaLogin"><img src="img/icon/edit-tools.svg" alt="home icon">
                        <h2>Pintura</h2>
                    </a>
                </div>
                <div class="service-icon">
                    <a href="../TelaLogin"><img src="img/icon/wheelbarrow.svg" alt="home icon">
                        <h2>Reforma</h2>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="about">
        <h1>Sobre</h1>
        <p>O Trampo é uma plataforma online na qual é permitido a procura por prestadores de serviços. Você pode
            contratar ou ser contratado se quiser prestar seus serviços, basta cadastrar-se, é de graça!</p>
        <div class="about-items">
            <div class="about-item">
                <img src="img/icon/about-icon-1.svg" class="about-icon">
                <h2>Encontre o que precisa</h2>
                <p>Você diz qual é o seu problema, e vê quem pode te ajudar.</p>
            </div>
            <div class="about-item">
                <img src="img/icon/about-icon-2.svg" class="about-icon">
                <h2>Escolha o prestador</h2>
                <p>Você que escolhe quem contratar, com base em reputação, experiência e localidade.</p>
            </div>
            <div class="about-item">
                <img src="img/icon/about-icon-3.svg" class="about-icon">
                <h2>Negocie e pronto!</h2>
                <p>Após a negociação, o pagamento é feito pela plataforma com total garantia.</p>
            </div>
        </div>
    </section>


    <section class="previous-experience">
        <h1>Experiência de quem já contratou</h1>
        <div class="previous-people">
            <div class="previous-person">
                <img src="img/thumbs/person1.jpg" alt="">
                <h2>Marcelo Silva</h2>
                <p>Ótima plataforma, posso escolher em quem eu confiar.</p>
            </div>
            <div class="previous-person">
                <img src="img/thumbs/person2.jpg" alt="">
                <h2>Felipe Paiva</h2>
                <p>Já usei e continuo usando, é o melhor jeito de contratar alguém.</p>
            </div>
            <div class="previous-person">
                <img src="img/thumbs/person3.jpg" alt="">
                <h2>Maria Alencar</h2>
                <p>Recomendo fortemente a todos. Tive total suporte da plataforma e meu problema resolvido.</p>
            </div>
        </div>
    </section>

    <section class="become-professional">
        <div class="call-to-action">
            <h1>Começar a contratar</h1>
            <a href="../UserRegister/"><button>Contratar!</button></a>
        </div>
        <h1>Você é um profissional?</h1>
        <p>Sabia que você pode cadastrar-se na plataforma Trampo e aumentar sua renda prestando serviços para diversas
            pessoas da sua localidade? Basta inserir os dados necessários e cadastra-se! e o melhor de tudo, você não
            paga nada por usar!</p>
        <a href="../UserRegister/">Cadastrar meus serviços</a>
    </section>

    <footer>
        <div>
            <h2>Serviços</h2>
            <a href="#">Assistência Técnica</a>
            <a href="#">Aulas</a>
            <a href="#">Consultoria</a>
            <a href="#">Design e Tecnologia</a>
        </div>
        <div>
            <h2>Redes Sociais</h2>
            <img src="img/icon/facebook-icon.png" alt="facebook icon" width="44px">
            <img src="img/icon/linkedin-icon.png" alt="linkedin icon" width="44px">
            <img src="img/icon/youtube-icon.png" alt="youtube icon" width="44px">
            <img src="img/icon/twitter-icon.png" alt="twitter icon" width="44px">
        </div>
        <div>
            <hr>
            <img src="img/logo/trampo_logo_normal.png" alt="trampo logo" width="100" class="normal-logo" style="display:inline">
            <p>© 2019 Trampo, todos os direitos resevados</p>
        </div>
    </footer>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>