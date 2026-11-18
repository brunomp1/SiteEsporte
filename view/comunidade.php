<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    die();
}

require "../php/funcoes.php";

$listaCampeonatos = retornarCampeonatos();   // para o campo "Sobre" (opcional)
$listaComentarios = retornarComentarios();   // comentários da comunidade

// Mensagens que os arquivos da pasta php mandam pela URL
$msg  = $_GET['msg']  ?? "";
$erro = $_GET['erro'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidade | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    

    <?php include "rodape.php"; ?>

</body>
</html>