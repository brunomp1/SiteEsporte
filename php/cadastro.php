<?php
require "funcoes.php";

// Cadastro de Torcedor
if (!empty($_POST['nome']) && !empty($_POST['email']) &&
    !empty($_POST['senha']) && !empty($_POST['telefone']) &&
    !empty($_POST['time']) && !empty($_POST['cidade'])) {

    // Recebendo
    $nome     = $_POST['nome'];
    $email    = $_POST['email'];
    $senha    = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $time     = $_POST['time'];
    $cidade   = $_POST['cidade'];

    // Confere se o email já existe
    $torcedor = retornarTorcedorPorEmail($email);

    if (mysqli_fetch_assoc($torcedor)) {
        echo "Este email já está cadastrado.";
    } else {
        // Salva no banco
        $resultado = inserirTorcedor($nome, $email, $senha, $telefone, $time, $cidade);

        if ($resultado) {
            header('Location: ../view/login.html');
            die();
        } else {
            echo "Erro ao cadastrar.";
        }
    }

} else {
    echo "Preencha todos os campos.";
}