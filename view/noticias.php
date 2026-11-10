<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

include "noticias-dados.php";
$c = $_GET['c'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">

        <h3 class="titulo-secao"><?php echo htmlspecialchars($c ?: "Últimas notícias"); ?></h3>

        <section class="grade">
            <?php foreach ($noticias as $n) { if ($c == "" || $n[0] == $c) { ?>
                <a class="card" href="#">
                    <div class="card-topo"><img src="../assets/Times/<?php echo $n[1]; ?>" alt=""></div>
                    <div class="card-texto">
                        <span class="tag"><?php echo $n[0]; ?></span>
                        <h4><?php echo $n[2]; ?></h4>
                    </div>
                </a>
            <?php } } ?>
        </section>

    </main>

    <?php include "rodape.php"; ?>

</body>
</html>