<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Afiliado | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/afiliado.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">

        <section class="apresentacao">
            <p class="texto-destaque">PROGRAMA DE AFILIAÇÃO</p>
            <h2>Seja um torcedor afiliado!</h2>
            <p>Escolha seu plano e aproveite benefícios exclusivos do seu time do coração.</p>
            <div class="escudos">
                <img src="../assets/Times/corinthians-logo-footylogos.svg" alt="Corinthians">
                <img src="../assets/Times/flamengo-logo-footylogos.svg" alt="Flamengo">
                <img src="../assets/Times/palmeiras-logo-footylogos.svg" alt="Palmeiras">
                <img src="../assets/Times/real-madrid-logo-footylogos.svg" alt="Real Madrid">
                <img src="../assets/Times/fc-barcelona-logo-footylogos.svg" alt="FC Barcelona">
                <img src="../assets/Times/liverpool-fc-logo-footylogos.svg" alt="Liverpool">
                <img src="../assets/Times/arsenal-logo-footylogos.svg" alt="Arsenal">
                <img src="../assets/Times/chelsea-logo-footylogos.svg" alt="Chelsea">
            </div>
        </section>

        <h3 class="titulo-secao">Por que se tornar afiliado?</h3>

        <section class="lista-beneficios">
            <div class="beneficio">
                <h3>Camisa do time</h3>
                <p>Ganhe uma camisa oficial fictícia do seu time, de acordo com o plano.</p>
            </div>
            <div class="beneficio">
                <h3>Ingressos</h3>
                <p>Tenha acesso a benefícios especiais para jogos do seu time.</p>
            </div>
            <div class="beneficio">
                <h3>Vantagens exclusivas</h3>
                <p>Participe de promoções e ações especiais para afiliados.</p>
            </div>
        </section>

        <h3 class="titulo-secao">Escolha seu plano</h3>

        <section class="lista-planos">

            <div class="cartao-plano">
                <h3>Arquibancada</h3>
                <p class="preco-plano">R$ 29,90 <span>/ mês</span></p>
                <ul>
                    <li>Acesso à comunidade de afiliados</li>
                    <li>Participação em promoções</li>
                    <li>Descontos em produtos</li>
                </ul>
                <!-- O ?plano=... leva o plano escolhido para o formulário de afiliar -->
                <a class="btn-plano" href="afiliar.php?plano=arquibancada">ESCOLHER PLANO</a>
            </div>

            <div class="cartao-plano plano-destaque">
                <span class="selo-plano">MAIS POPULAR</span>
                <h3>Camisa</h3>
                <p class="preco-plano">R$ 59,90 <span>/ mês</span></p>
                <ul>
                    <li>Todos os benefícios anteriores</li>
                    <li>Uma camisa do seu time por ano</li>
                    <li>Descontos especiais</li>
                </ul>
                <a class="btn-plano" href="afiliar.php?plano=camisa">ESCOLHER PLANO</a>
            </div>

            <div class="cartao-plano">
                <h3>Fiel Torcedor</h3>
                <p class="preco-plano">R$ 89,90 <span>/ mês</span></p>
                <ul>
                    <li>Todos os benefícios anteriores</li>
                    <li>Um ingresso fictício por ano</li>
                    <li>Experiências exclusivas</li>
                </ul>
                <a class="btn-plano" href="afiliar.php?plano=fiel">ESCOLHER PLANO</a>
            </div>

        </section>

        <p class="aviso-planos">*Planos e benefícios ilustrativos para fins acadêmicos.</p>

    </main>

    <?php include "rodape.php"; ?>

</body>
</html>