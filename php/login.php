<?php
session_start();
require "conexao.php";

// Login do Torcedor
if (!empty($_POST['email']) && !empty($_POST['senha'])) {

    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Procura o email no banco
    $stmt = $conexao->prepare("SELECT id, nome, senha FROM torcedores WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Confere a senha digitada com a senha criptografada do banco
        if (password_verify($senha, $usuario['senha'])) {

            // Guarda quem entrou
            $_SESSION['id']   = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: ../view/home.php");
            exit;
        }
    }

    // Email ou senha errados: volta para o login com aviso
    header("Location: ../view/login.html?erro=1");
    exit;

} else {
    // Campos vazios: volta para o login com aviso
    header("Location: ../view/login.html?erro=2");
    exit;
}