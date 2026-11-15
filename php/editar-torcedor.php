<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

require "../php/conexao.php";

// 1) Pega o id que veio na URL (editar-torcedor.php?id=3).
//    (int) transforma em número: se alguém escrever texto estranho, vira 0.
$id = (int) ($_GET['id'] ?? 0);

// 2) Busca esse torcedor no banco
$stmt = $conexao->prepare("SELECT id, nome, email, telefone, time_clube, cidade FROM torcedores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

// 3) Se não achou ninguém com esse id, volta para a lista
if ($resultado->num_rows == 0) {
    header("Location: torcedores.php?msg=erro");
    exit;
}

// $t agora é um "array" com os dados: $t['nome'], $t['email'], ...
$t = $resultado->fetch_assoc();

// Mensagem de erro que o php/editar.php pode mandar de volta pela URL
$erro = $_GET['erro'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Torcedor | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Editar torcedor</h3>

        <?php if ($erro == "vazio") { ?>
            <p class="aviso aviso-erro">Preencha todos os campos.</p>
        <?php } elseif ($erro == "email") { ?>
            <p class="aviso aviso-erro">Este email já está sendo usado por outro torcedor.</p>
        <?php } elseif ($erro == "salvar") { ?>
            <p class="aviso aviso-erro">Erro ao salvar as alterações.</p>
        <?php } ?>

        <form class="form-edicao" action="../php/editar.php" method="post">
            <!-- O id vai escondido: o usuário não vê, mas o PHP precisa saber QUEM está sendo editado -->
            <input type="hidden" name="id" value="<?php echo (int) $t['id']; ?>">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($t['nome']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($t['email']); ?>" required>

            <label for="telefone">Telefone</label>
            <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($t['telefone']); ?>" required>

            <label for="time">Time</label>
            <input type="text" id="time" name="time" list="lista-times" autocomplete="off"
                   value="<?php echo htmlspecialchars($t['time_clube']); ?>" required>

            <datalist id="lista-times">
                <option value="Amazonas">
                <option value="Araguaia">
                <option value="Arsenal">
                <option value="Atlético de Madrid">
                <option value="Boca Juniors">
                <option value="Chelsea">
                <option value="Corinthians">
                <option value="Everton">
                <option value="FC Barcelona">
                <option value="Flamengo">
                <option value="Harrogate Town">
                <option value="Liverpool">
                <option value="Manchester United">
                <option value="Mirassol">
                <option value="Morecambe">
                <option value="Palmeiras">
                <option value="Portuguesa-RJ">
                <option value="Real Madrid">
                <option value="Sporting CP">
                <option value="Ypiranga">
            </datalist>

            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($t['cidade']); ?>" required>

            <div class="botoes-form">
                <button type="submit" class="btn-salvar">SALVAR</button>
                <a class="btn-cancelar" href="torcedores.php">CANCELAR</a>
            </div>
        </form>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>
