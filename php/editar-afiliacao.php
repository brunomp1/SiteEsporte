<?php
// Recebe o formulário de editar e atualiza a afiliação no banco.
session_start();
require "conexao.php";

// Só quem está logado pode editar
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit;
}

// Só aceita dados enviados pelo formulário (POST)
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: ../view/afiliacoes.php");
    exit;
}

// Dados do formulário
$id        = (int) $_POST['id'];
$torcedor  = (int) $_POST['torcedor'];
$time      = $_POST['time'];
$plano     = $_POST['plano'];
$pagamento = $_POST['pagamento'];

// A coluna criado_em (hora do pagamento) não muda: continua a hora em que foi registrado
$stmt = $conexao->prepare(
    "UPDATE afiliacoes
     SET torcedor_id = ?, time_clube = ?, plano = ?, pagamento = ?
     WHERE id = ?"
);
// i s s s i -> na mesma ordem dos "?"
$stmt->bind_param("isssi", $torcedor, $time, $plano, $pagamento, $id);

try {
    $stmt->execute();
    header("Location: ../view/afiliacoes.php?msg=editado");
} catch (Exception $erro) {
    header("Location: ../view/editar-afiliacao.php?id=$id&erro=salvar");
}
exit;