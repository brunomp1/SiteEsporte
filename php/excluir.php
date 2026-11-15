<?php
session_start();
require "conexao.php";

// Só quem está logado pode excluir
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit;
}

// Excluir só funciona com POST (botão do formulário). Se alguém digitar o endereço na barra, nada acontece.
if ($_SERVER['REQUEST_METHOD'] != "POST" || empty($_POST['id'])) {
    header("Location: ../view/torcedores.php");
    exit;
}

$id = (int) $_POST['id'];

// Antes de apagar o torcedor, apaga as afiliações dele
$apagaAfiliacoes = $conexao->prepare("DELETE FROM afiliacoes WHERE torcedor_id = ?");
$apagaAfiliacoes->bind_param("i", $id);
$apagaAfiliacoes->execute();

// Apaga a linha do  id é igual ao enviado
$stmt = $conexao->prepare("DELETE FROM torcedores WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Se a pessoa excluiu a própria conta, ela não existe mais: encerra a sessão e vai para o login
    if ($id == $_SESSION['id']) {
        session_unset();
        session_destroy();
        header("Location: ../view/login.html");
        exit;
    }
    header("Location: ../view/torcedores.php?msg=excluido");
} else {
    header("Location: ../view/torcedores.php?msg=erro");
}
exit;
