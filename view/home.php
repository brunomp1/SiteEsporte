<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

include "noticias-dados.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">

        <p class="saudacao">Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</p>

        <section class="jogos">
            <div class="jogo">
                <img src="../assets/Times/real-madrid-logo-footylogos.svg" alt="Real Madrid">
                <strong>16:00</strong>
                <img src="../assets/Times/fc-barcelona-logo-footylogos.svg" alt="FC Barcelona">
            </div>
            <div class="jogo">
                <img src="../assets/Times/liverpool-fc-logo-footylogos.svg" alt="Liverpool">
                <strong>13:30</strong>
                <img src="../assets/Times/arsenal-logo-footylogos.svg" alt="Arsenal">
            </div>
            <div class="jogo">
                <img src="../assets/Times/palmeiras-logo-footylogos.svg" alt="Palmeiras">
                <strong>18:30</strong>
                <img src="../assets/Times/flamengo-logo-footylogos.svg" alt="Flamengo">
            </div>
        </section>

        <section class="destaque-area">
            <a class="destaque" href="noticias.php?c=Brasileirão">
                <img class="marca" src="../assets/Times/flamengo-logo-footylogos.svg" alt="">
                <span class="tag">Brasileirão</span>
                <h2>Rodada decisiva: veja o que está em jogo no fim de semana</h2>
            </a>

            <aside class="mais-lidas">
                <h3>Mais lidas</h3>
                <ol>
                    <?php foreach (array_slice($noticias, 0, 5) as $n) { ?>
                        <li><a href="noticias.php?c=<?php echo $n[0]; ?>"><?php echo $n[2]; ?></a></li>
                    <?php } ?>
                </ol>
            </aside>
        </section>

        <h3 class="titulo-secao">Últimas notícias</h3>

        <section class="grade">
            <?php foreach (array_slice($noticias, 0, 3) as $n) { ?>
                <a class="card" href="noticias.php?c=<?php echo $n[0]; ?>">
                    <div class="card-topo"><img src="../assets/Times/<?php echo $n[1]; ?>" alt=""></div>
                    <div class="card-texto">
                        <span class="tag"><?php echo $n[0]; ?></span>
                        <h4><?php echo $n[2]; ?></h4>
                    </div>
                </a>
            <?php } ?>
        </section>

    </main>

    <?php include "rodape.php"; ?>

</body>
</html>