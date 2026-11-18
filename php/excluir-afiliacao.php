<?php
// Exclui uma afiliação.
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

    $resultado = excluirAfiliacao($id);

    if ($resultado) {
        header('Location: ../view/afiliacoes.php?msg=excluido');
    } else {
        header('Location: ../view/afiliacoes.php?msg=erro');
    }

} else {
    header('Location: ../view/afiliacoes.php');
}
die();