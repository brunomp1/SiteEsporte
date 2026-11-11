<?php
require "conexao.php";

// Cadastro de Torcedor
if (!empty($_POST['nome']) && !empty($_POST['email']) &&
    !empty($_POST['senha']) && !empty($_POST['telefone']) &&
    !empty($_POST['time']) && !empty($_POST['cidade'])) {

    // Recebendo
    $nome     = trim($_POST['nome']);
    $email    = trim($_POST['email']);
    $senha    = trim($_POST['senha']);
    $telefone = trim($_POST['telefone']);
    $time     = trim($_POST['time']);
    $cidade   = trim($_POST['cidade']);

    // Confere se o email já existe
    $verifica = $conexao->prepare("SELECT id FROM torcedores WHERE email = ?");
    $verifica->bind_param("s", $email);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        echo "Este email já está cadastrado.";
    } else {
        // Salva banco
        $stmt = $conexao->prepare(
            "INSERT INTO torcedores (nome, email, senha, telefone, time_clube, cidade)
             VALUES (?, ?, ?, ?, ?, ?)" //Prenenche vazio
        );
        $stmt->bind_param("ssssss", $nome, $email, $senha, $telefone, $time, $cidade); //sss paar indicar que é string para não tomar sql

        if ($stmt->execute()) {
            header("Location: ../view/login.html");
            exit;
        } else {
            echo "Erro ao cadastrar.";
        }
    }

} else {
    echo "Preencha todos os campos.";
}