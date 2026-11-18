<?php
// Recebe o formulário de editar time e atualiza no banco.
session_start();
require "funcoes.php";

// Só quem está logado pode editar
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

if (!empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['cidade']) &&
    !empty($_POST['pais']) && !empty($_POST['ano'])) {

    $id     = (int) $_POST['id'];
    $nome   = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $pais   = $_POST['pais'];
    $ano    = (int) $_POST['ano'];

    // Confere se OUTRO time já usa esse nome
    $time = retornarTimeDuplicado($nome, $id);

    if (mysqli_fetch_assoc($time)) {
        header('Location: ../view/editar-time.php?id=' . $id . '&erro=existe');
    } else {
        $resultado = atualizarTime($id, $nome, $cidade, $pais, $ano);

        if ($resultado) {
            header('Location: ../view/times.php?msg=editado');
        } else {
            header('Location: ../view/editar-time.php?id=' . $id . '&erro=salvar');
        }
    }

} else {
    header('Location: ../view/times.php');
}
die();