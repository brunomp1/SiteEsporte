<?php
// Exclui um time.
session_start();
require "funcoes.php";

// Só quem está logado pode excluir
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

// O id vem escondido no formulário (POST)
if (!empty($_POST['id'])) {

    $id = (int) $_POST['id'];

    $resultado = excluirTime($id);

    if ($resultado) {
        header('Location: ../view/times.php?msg=excluido');
    } else {
        header('Location: ../view/times.php?msg=erro');
    }

} else {
    header('Location: ../view/times.php');
}
die();