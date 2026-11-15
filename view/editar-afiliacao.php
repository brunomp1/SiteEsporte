<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

require "../php/conexao.php";
include "afiliacao-dados.php";

// 1) Pega o id que veio na URL (editar-afiliacao.php?id=3). O (int) transforma em número.
$id = (int) ($_GET['id'] ?? 0);

// 2) Busca essa afiliação no banco
$stmt = $conexao->prepare(
    "SELECT id, torcedor_id, time_clube, plano, pagamento,
            DATE_FORMAT(criado_em, '%d/%m/%Y %H:%i') AS hora
     FROM afiliacoes WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

// 3) Se não achou, volta para a lista
if ($resultado->num_rows == 0) {
    header("Location: afiliacoes.php?msg=erro");
    exit;
}

// $a agora é um array com os dados: $a['plano'], $a['pagamento'], ...
$a = $resultado->fetch_assoc();

// Torcedores para o campo "Torcedor"
$torcedores = $conexao->query("SELECT id, nome, email FROM torcedores ORDER BY nome");

$acao  = "../php/editar-afiliacao.php";
$botao = "SALVAR";

// Mensagem de erro que o php/editar-afiliacao.php pode mandar de volta pela URL
$erro = $_GET['erro'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Afiliação | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Editar afiliação</h3>

        <?php if ($erro == "salvar") { ?>
            <p class="aviso aviso-erro">Erro ao salvar as alterações.</p>
        <?php } ?>

        <?php include "form-afiliacao.php"; ?>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>