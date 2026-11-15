<?php
// Recebe o formulário de afiliar e salva no banco.
session_start();
require "conexao.php";

// Só quem está logado pode afiliar
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
$torcedor  = (int) $_POST['torcedor'];
$time      = $_POST['time'];
$plano     = $_POST['plano'];
$pagamento = $_POST['pagamento'];

// A hora do pagamento não é enviada: o banco guarda sozinho na coluna criado_em
$stmt = $conexao->prepare(
    "INSERT INTO afiliacoes (torcedor_id, time_clube, plano, pagamento)
     VALUES (?, ?, ?, ?)"
);
// i = número inteiro, s = texto, na mesma ordem dos "?"
$stmt->bind_param("isss", $torcedor, $time, $plano, $pagamento);

try {
    $stmt->execute();
    header("Location: ../view/afiliacoes.php?msg=afiliado");
} catch (Exception $erro) {
    header("Location: ../view/afiliar.php?erro=salvar");
}
exit;