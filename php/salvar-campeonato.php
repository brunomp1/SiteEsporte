<?php
// Cadastra ou edita um campeonato (o mesmo arquivo faz os dois).
session_start();
require "funcoes.php";

// Só quem está logado pode salvar
if (!isset($_SESSION['id'])) {
    header('Location: ../view/login.html');
    die();
}

$nome = trim($_POST['nome'] ?? "");
$ano  = (int) ($_POST['ano'] ?? 0);

if ($nome != "" && $ano > 0) {

    // Times marcados na tela (podem ser nenhum), tira nomes repetidos.
    $listaTimes = [];
    if (isset($_POST['times']) && is_array($_POST['times'])) {
        $listaTimes = array_unique($_POST['times']);
    }

    if (!empty($_POST['id'])) {
        // Veio o id escondido: é uma edição
        $resultado = atualizarCampeonato((int) $_POST['id'], $nome, $ano, $listaTimes);
        $msg = "editado";
    } else {
        // Sem id: campeonato novo
        $resultado = inserirCampeonato($nome, $ano, $listaTimes);
        $msg = "cadastrado";
    }

    if ($resultado) {
        header('Location: ../view/campeonatos.php?msg=' . $msg);
    } else {
        header('Location: ../view/campeonatos.php?erro=salvar');
    }

} else {
    header('Location: ../view/campeonatos.php?erro=vazio');
}
die();