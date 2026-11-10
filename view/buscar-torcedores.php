<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

require "../php/conexao.php";

$time   = trim($_GET['time'] ?? "");
$cidade = trim($_GET['cidade'] ?? "");
$resultado = null;

// Só busca se a pessoa preencheu algum campo
if ($time != "" || $cidade != "") {
    $likeTime   = "%" . $time . "%";
    $likeCidade = "%" . $cidade . "%";

    $stmt = $conexao->prepare(
        "SELECT nome, telefone, time_clube, cidade FROM torcedores
         WHERE time_clube LIKE ? AND cidade LIKE ? ORDER BY nome"
    );
    $stmt->bind_param("ss", $likeTime, $likeCidade);
    $stmt->execute();
    $resultado = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Torcedores | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Buscar torcedores</h3>

        <form class="busca" method="get">
            <input type="text" name="time" placeholder="Time" value="<?php echo htmlspecialchars($time); ?>">
            <input type="text" name="cidade" placeholder="Cidade" value="<?php echo htmlspecialchars($cidade); ?>">
            <button type="submit">BUSCAR</button>
        </form>

        <?php if ($resultado) { include "tabela-torcedores.php"; } ?>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>