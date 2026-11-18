<?php
// Exclui um campeonato.
session_start();
require "funcoes.php";

// Só quem está logado pode excluir
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

// O id vem escondido no formulário (POST)
if (!empty($_POST['id'])) {

    $resultado = excluirCampeonato((int) $_POST['id']);

    if ($resultado) {
        header('Location: ../view/campeonatos.php?msg=excluido');
    } else {
        header('Location: ../view/campeonatos.php?erro=excluir');
    }

} else {
    header('Location: ../view/campeonatos.php');
}
die();