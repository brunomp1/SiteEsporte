<?php
session_start();
require "conexao.php";

// Só quem está logado pode editar
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit;
}

// Só aceita dados enviados pelo formulário (POST). Se alguém abrir o arquivo direto, volta para a lista.
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: ../view/torcedores.php");
    exit;
}

// Recebendo os dados do formulário
$id       = (int) ($_POST['id'] ?? 0);
$nome     = trim($_POST['nome'] ?? "");
$email    = trim($_POST['email'] ?? "");
$telefone = trim($_POST['telefone'] ?? "");
$time     = trim($_POST['time'] ?? "");
$cidade   = trim($_POST['cidade'] ?? "");

// Se faltou algum campo, volta para a tela de edição com aviso
if ($id == 0 || $nome == "" || $email == "" || $telefone == "" || $time == "" || $cidade == "") {
    header("Location: ../view/editar-torcedor.php?id=$id&erro=vazio");
    exit;
}

// O email é UNIQUE no banco: dois torcedores não podem ter o mesmo.
// Então procuro se OUTRO torcedor (id diferente do que estou editando) já usa esse email.
$verifica = $conexao->prepare("SELECT id FROM torcedores WHERE email = ? AND id <> ?");
$verifica->bind_param("si", $email, $id);
$verifica->execute();
$verifica->store_result();

if ($verifica->num_rows > 0) {
    header("Location: ../view/editar-torcedor.php?id=$id&erro=email");
    exit;
}

// Atualiza o torcedor. Os "?" serão trocados pelos valores no bind_param (protege contra SQL Injection).
$stmt = $conexao->prepare(
    "UPDATE torcedores
     SET nome = ?, email = ?, telefone = ?, time_clube = ?, cidade = ?
     WHERE id = ?"
);
// 5 textos (s) e 1 número inteiro (i) -> "sssssi", na mesma ordem dos "?"
$stmt->bind_param("sssssi", $nome, $email, $telefone, $time, $cidade, $id);

if ($stmt->execute()) {
    // Se a pessoa editou o próprio cadastro, atualiza o nome que aparece no "Olá, ...!" da home
    if ($id == $_SESSION['id']) {
        $_SESSION['nome'] = $nome;
    }
    header("Location: ../view/torcedores.php?msg=editado");
} else {
    header("Location: ../view/editar-torcedor.php?id=$id&erro=salvar");
}
exit;
