<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    die();
}

// Mensagem de erro que o php/cadastro-time.php pode mandar de volta pela URL
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
    <title>Cadastrar Time | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Cadastrar time</h3>

        <?php if ($erro == "vazio") { ?>
            <p class="aviso aviso-erro">Preencha todos os campos.</p>
        <?php } elseif ($erro == "existe") { ?>
            <p class="aviso aviso-erro">Este time já está cadastrado.</p>
        <?php } elseif ($erro == "salvar") { ?>
            <p class="aviso aviso-erro">Erro ao cadastrar o time.</p>
        <?php } ?>

        <form class="form-edicao" action="../php/cadastro-time.php" method="post">

            <label for="nome">Nome do time</label>
            <input type="text" id="nome" name="nome" autocomplete="off" required>

            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" required>

            <label for="pais">País</label>
            <input type="text" id="pais" name="pais" required>

            <label for="ano">Ano de fundação</label>
            <input type="text" id="ano" name="ano" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" placeholder="Ex.: 1910" required>

            <div class="botoes-form">
                <button type="submit" class="btn-salvar">CADASTRAR</button>
                <a class="btn-cancelar" href="times.php">CANCELAR</a>
            </div>
        </form>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>