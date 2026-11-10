<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

require "../php/conexao.php";

$resultado = $conexao->query("SELECT nome, telefone, time_clube, cidade FROM torcedores ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torcedores | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Torcedores cadastrados</h3>

        <?php include "tabela-torcedores.php"; ?>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>