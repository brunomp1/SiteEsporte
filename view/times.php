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
        <?php } elseif ($msg == "editado") { ?>
            <p class="aviso aviso-ok">Time atualizado com sucesso.</p>
        <?php } elseif ($msg == "excluido") { ?>
            <p class="aviso aviso-ok">Time excluído com sucesso.</p>
        <?php } elseif ($msg == "erro") { ?>
            <p class="aviso aviso-erro">Não foi possível concluir a operação.</p>
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
                        <th>Ações</th>
                    </tr>
                    <?php while ($t = mysqli_fetch_assoc($listaTimes)) { ?>
                        <tr>
                            <td><?php echo $t['nome']; ?></td>
                            <td><?php echo $t['cidade']; ?></td>
                            <td><?php echo $t['pais']; ?></td>
                            <td><?php echo $t['ano_fundacao']; ?></td>
                            <td class="acoes">
                                <a class="btn-editar" href="editar-time.php?id=<?php echo (int) $t['id']; ?>">Editar</a>

                                <form class="form-excluir" action="../php/excluir-time.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo (int) $t['id']; ?>">
                                    <button type="submit" class="btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>