<?php

session_start();
require "funcoes.php";

// Só quem está logado pode editar
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

// Dados do formulário (POST)
if (!empty($_POST['id']) && !empty($_POST['torcedor']) && !empty($_POST['time']) &&
    !empty($_POST['plano']) && !empty($_POST['pagamento'])) {

    $id        = (int) $_POST['id'];
    $torcedor  = (int) $_POST['torcedor'];
    $time      = $_POST['time'];
    $plano     = $_POST['plano'];
    $pagamento = $_POST['pagamento'];

    $resultado = atualizarAfiliacao($id, $torcedor, $time, $plano, $pagamento);

    if ($resultado) {
        header('Location: ../view/afiliacoes.php?msg=editado');
    } else {
        header('Location: ../view/editar-afiliacao.php?id=' . $id . '&erro=salvar');
    }

} else {
    header('Location: ../view/afiliacoes.php');
}
die();