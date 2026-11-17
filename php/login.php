<?php
session_start();
require "funcoes.php";

if (!empty($_POST['email']) && !empty($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $resultado = retornarLogin($email, $senha);
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario) {
        $_SESSION['id']   = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        header('Location: ../view/home.php');
    } else {
        header('Location: ../view/login.html?erro=1');
    }

} else {
    header('Location: ../view/login.html?erro=2');
}
die();