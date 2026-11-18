<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    die();
}

require "../php/funcoes.php";

// Pega o id que veio na URL (editar-time.php?id=3). O (int) transforma em número.
$id = 0;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

// Busca esse time no banco
$resultado = retornarTimePorId($id);
$t = mysqli_fetch_assoc($resultado);

// Se não achou, volta para a lista
if (!$t) {
    header('Location: times.php?msg=erro');
    die();
}

// Mensagem de erro que o php/editar-time.php pode mandar de volta pela URL
$erro = "";
if (isset($_GET['erro'])) {
    $erro = $_GET['erro'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Time | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Editar time</h3>

        <?php if ($erro == "existe") { ?>
            <p class="aviso aviso-erro">Já existe outro time com esse nome.</p>
        <?php } elseif ($erro == "salvar") { ?>
            <p class="aviso aviso-erro">Erro ao salvar as alterações.</p>
        <?php } ?>

        <form class="form-edicao" action="../php/editar-time.php" method="post">

            <input type="hidden" name="id" value="<?php echo $t['id']; ?>">

            <label for="nome">Nome do time</label>
            <input type="text" id="nome" name="nome" autocomplete="off" value="<?php echo $t['nome']; ?>" required>

            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" value="<?php echo $t['cidade']; ?>" required>

            <label for="pais">País</label>
            <input type="text" id="pais" name="pais" value="<?php echo $t['pais']; ?>" required>

            <label for="ano">Ano de fundação</label>
            <input type="text" id="ano" name="ano" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" value="<?php echo $t['ano_fundacao']; ?>" required>

            <div class="botoes-form">
                <button type="submit" class="btn-salvar">SALVAR</button>
                <a class="btn-cancelar" href="times.php">CANCELAR</a>
            </div>
        </form>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>