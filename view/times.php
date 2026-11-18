<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    die();
}

require "../php/funcoes.php";

// Função do funcoes.php que retorna todos os times cadastrados
$listaTimes = retornarTimes();

$msg = "";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Times | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Times cadastrados</h3>

        <?php if ($msg == "cadastrado") { ?>
            <p class="aviso aviso-ok">Time cadastrado com sucesso.</p>
        <?php } ?>

        <?php if (mysqli_num_rows($listaTimes) == 0) { ?>
            <p>Nenhum time cadastrado.</p>
        <?php } else { ?>
            <div class="tabela-area">
                <table class="tabela">
                    <tr>
                        <th>Nome</th>
                        <th>Cidade</th>
                        <th>País</th>
                        <th>Ano de fundação</th>
                    </tr>
                    <?php while ($t = mysqli_fetch_assoc($listaTimes)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($t['nome']); ?></td>
                            <td><?php echo htmlspecialchars($t['cidade']); ?></td>
                            <td><?php echo htmlspecialchars($t['pais']); ?></td>
                            <td><?php echo $t['ano_fundacao']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>