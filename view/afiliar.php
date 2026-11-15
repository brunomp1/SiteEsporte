<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

require "../php/conexao.php";
include "afiliacao-dados.php";

// Torcedores para o campo "Torcedor"
$torcedores = $conexao->query("SELECT id, nome, email FROM torcedores ORDER BY nome");

// Afiliação nova: todos os campos começam vazios
$a = ["id" => "", "torcedor_id" => "", "time_clube" => "", "plano" => "", "pagamento" => "", "hora" => ""];
// Se veio da página de planos (afiliar.php?plano=camisa), já deixa o plano escolhido
$a['plano'] = $_GET['plano'] ?? "";
$acao  = "../php/afiliar.php";
$botao = "AFILIAR";

// Mensagem de erro que o php/afiliar.php pode mandar de volta pela URL
$erro = $_GET['erro'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afiliar | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Afiliar torcedor</h3>

        <?php if ($erro == "salvar") { ?>
            <p class="aviso aviso-erro">Erro ao salvar a afiliação.</p>
        <?php } ?>

        <?php include "form-afiliacao.php"; ?>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>