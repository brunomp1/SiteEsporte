<?php
// Salva um comentário da comunidade.
session_start();
require "funcoes.php";

// Só quem está logado pode comentar
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

// O mb_substr corta o texto em 500 letras (o tamanho da coluna texto)
$texto      = mb_substr(trim($_POST['texto'] ?? ""), 0, 500);
$campeonato = (int) ($_POST['campeonato'] ?? 0);

if ($texto != "") {

    // Se o campeonato escolhido não existe mais, vira um comentário geral
    if ($campeonato > 0 && !mysqli_fetch_assoc(retornarCampeonatoPorId($campeonato))) {
        $campeonato = 0;
    }

    // Quem comenta é sempre quem está logado ($_SESSION['id'])
    $resultado = inserirComentario((int) $_SESSION['id'], $campeonato, $texto);

    if ($resultado) {
        header('Location: ../view/comunidade.php?msg=publicado');
    } else {
        header('Location: ../view/comunidade.php?erro=salvar');
    }

} else {
    header('Location: ../view/comunidade.php?erro=vazio');
}
die();