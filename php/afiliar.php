<?php
// Recebe o formulário de afiliar e salva no banco.
session_start();
require "funcoes.php";

// Só quem está logado pode afiliar
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

if (!empty($_POST['torcedor']) && !empty($_POST['time']) &&
    !empty($_POST['plano']) && !empty($_POST['pagamento'])) {

    $torcedor  = (int) $_POST['torcedor'];
    $time      = $_POST['time'];
    $plano     = $_POST['plano'];
    $pagamento = $_POST['pagamento'];

    $resultado = inserirAfiliacao($torcedor, $time, $plano, $pagamento);

    if ($resultado) {
        header('Location: ../view/afiliacoes.php?msg=afiliado');
    } else {
        header('Location: ../view/afiliar.php?erro=salvar');
    }

} else {
    header('Location: ../view/afiliacoes.php');
}
die();