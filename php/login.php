<?php
session_start();
require "conexao.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

$resultado = $conexao->query("SELECT id, nome FROM torcedores WHERE email = '$email' AND senha = '$senha'");

if ($resultado->num_rows == 1) {
    $usuario = $resultado->fetch_assoc();
    $_SESSION['id']   = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    header("Location: ../view/home.php");
} else {
    header("Location: ../view/login.html?erro=1");
}
