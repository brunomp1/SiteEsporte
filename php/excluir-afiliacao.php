<?php
// Exclui uma afiliação.
session_start();
require "conexao.php";

// Só quem está logado pode excluir
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit;
}

// Excluir só funciona com POST (botão do formulário). Se alguém digitar o endereço na barra, nada acontece.
if ($_SERVER['REQUEST_METHOD'] != "POST" || empty($_POST['id'])) {
    header("Location: ../view/afiliacoes.php");
    exit;
}

$id = (int) $_POST['id'];

// Apaga a linha cujo id é igual ao enviado. O WHERE é ESSENCIAL: sem ele apagaria TODAS as afiliações!
$stmt = $conexao->prepare("DELETE FROM afiliacoes WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../view/afiliacoes.php?msg=excluido");
} else {
    header("Location: ../view/afiliacoes.php?msg=erro");
}
exit;