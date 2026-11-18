<?php
// Recebe o formulário de cadastrar time e salva no banco.
session_start();
require "funcoes.php";

// Só quem está logado pode cadastrar time
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

// Cadastro de Time
if (!empty($_POST['nome']) && !empty($_POST['cidade']) &&
    !empty($_POST['pais']) && !empty($_POST['ano'])) {

    // Recebendo
    $nome   = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $pais   = $_POST['pais'];
    $ano    = (int) $_POST['ano'];

    // Confere se o time já existe
    $time = retornarTimePorNome($nome);

    if (mysqli_fetch_assoc($time)) {
        header('Location: ../view/cadastrar-time.php?erro=existe');
    } else {
        // Salva no banco
        $resultado = inserirTime($nome, $cidade, $pais, $ano);

        if ($resultado) {
            header('Location: ../view/times.php?msg=cadastrado');
        } else {
            header('Location: ../view/cadastrar-time.php?erro=salvar');
        }
    }

} else {
    header('Location: ../view/cadastrar-time.php?erro=vazio');
}
die();