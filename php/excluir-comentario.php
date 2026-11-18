<?php
// Exclui um comentário (só o dono consegue).
session_start();
require "funcoes.php";

// Só quem está logado pode excluir
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

// O id do comentário vem escondido no formulário (POST)
if (!empty($_POST['id'])) {

    $resultado = excluirComentario((int) $_POST['id'], (int) $_SESSION['id']);

    if ($resultado) {
        header('Location: ../view/comunidade.php?msg=excluido');
    } else {
        header('Location: ../view/comunidade.php?erro=excluir');
    }

} else {
    header('Location: ../view/comunidade.php');
}
die();