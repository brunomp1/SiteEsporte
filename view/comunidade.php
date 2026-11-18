<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    die();
}

require "../php/funcoes.php";

$listaCampeonatos = retornarCampeonatos();   // para o campo "Sobre" (opcional)
$listaComentarios = retornarComentarios();   // comentários da comunidade

// Mensagens que os arquivos da pasta php mandam pela URL
$msg  = $_GET['msg']  ?? "";
$erro = $_GET['erro'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidade | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Comunidade</h3>

        <?php if ($msg == "publicado") { ?>
            <p class="aviso aviso-ok">Comentário publicado.</p>
        <?php } elseif ($msg == "excluido") { ?>
            <p class="aviso aviso-ok">Comentário excluído.</p>
        <?php } elseif ($erro == "vazio") { ?>
            <p class="aviso aviso-erro">Escreva alguma coisa antes de publicar.</p>
        <?php } elseif ($erro == "salvar") { ?>
            <p class="aviso aviso-erro">Erro ao publicar o comentário.</p>
        <?php } elseif ($erro == "excluir") { ?>
            <p class="aviso aviso-erro">Erro ao excluir o comentário.</p>
        <?php } ?>

        <!-- ========== NOVO COMENTÁRIO ========== -->
        <form class="form-edicao" action="../php/comentar.php" method="post">

            <label for="texto">Seu comentário, <?php echo htmlspecialchars($_SESSION['nome']); ?></label>
            <textarea id="texto" name="texto" rows="4" maxlength="500" placeholder="Fale sobre o jogo, o campeonato, o seu time..." required></textarea>

            <label for="campeonato">Sobre (opcional)</label>
            <select id="campeonato" name="campeonato">
                <option value="0">Comunidade em geral</option>
                <?php while ($camp = mysqli_fetch_assoc($listaCampeonatos)) { ?>
                    <option value="<?php echo (int) $camp['id']; ?>">
                        <?php echo htmlspecialchars($camp['nome'] . " (" . $camp['ano'] . ")"); ?>
                    </option>
                <?php } ?>
            </select>

            <div class="botoes-form">
                <button type="submit" class="btn-salvar">PUBLICAR</button>
            </div>
        </form>

        <!-- ========== COMENTÁRIOS ========== -->
        <h3 class="titulo-secao">Últimos comentários</h3>

        <?php if (mysqli_num_rows($listaComentarios) == 0) { ?>
            <p>Ainda não há comentários. Seja o primeiro!</p>
        <?php } else { ?>
            <?php while ($com = mysqli_fetch_assoc($listaComentarios)) { ?>
                <div class="comentario">
                    <div class="comentario-topo">
                        <strong><?php echo htmlspecialchars($com['nome']); ?></strong>
                        <span class="comentario-hora"><?php echo $com['hora']; ?></span>
                    </div>

                    <?php if ($com['campeonato'] != "") { ?>
                        <span class="tag-campeonato"><?php echo htmlspecialchars($com['campeonato']); ?></span>
                    <?php } ?>

                    <!-- nl2br mantém as quebras de linha que a pessoa digitou -->
                    <p><?php echo nl2br(htmlspecialchars($com['texto'])); ?></p>

                    <!-- O botão de excluir só aparece nos comentários de quem está logado -->
                    <?php if ($com['torcedor_id'] == $_SESSION['id']) { ?>
                        <form class="form-excluir" action="../php/excluir-comentario.php" method="post"
                              onsubmit="return confirm('Tem certeza que deseja excluir este comentário?');">
                            <input type="hidden" name="id" value="<?php echo (int) $com['id']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
    </main>

    <?php include "rodape.php"; ?>

</body>
</html>