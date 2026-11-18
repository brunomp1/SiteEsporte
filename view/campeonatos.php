<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.html');
    die();
}

require "../php/funcoes.php";

// Traz $times = a lista dos times pré-cadastrados (a mesma usada na afiliação)
include "afiliacao-dados.php";

// Se a URL tem ?id=3, a tela abre em modo EDITAR com os dados do campeonato 3.
// Sem id, o formulário fica vazio para CADASTRAR.
$c = ["id" => "", "nome" => "", "ano" => ""];
$marcados = [];   // nomes dos times já escolhidos neste campeonato

if (isset($_GET['id'])) {
    $achou = mysqli_fetch_assoc(retornarCampeonatoPorId((int) $_GET['id']));

    if ($achou) {
        $c = $achou;

        // Guarda os nomes dos times do campeonato para deixar as caixinhas marcadas
        $listaMarcados = retornarTimesDoCampeonato($c['id']);
        while ($linha = mysqli_fetch_assoc($listaMarcados)) {
            $marcados[] = $linha['time_nome'];
        }
    }
}

$timesCadastrados = retornarTimes();          // times da tabela times
$listaCampeonatos = retornarCampeonatos();    // campeonatos para a tabela

// Mensagens que os arquivos da pasta php mandam pela URL
$msg  = $_GET['msg']  ?? "";
$erro = $_GET['erro'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campeonatos | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/rodape.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">

        <?php if ($msg == "cadastrado") { ?>
            <p class="aviso aviso-ok">Campeonato cadastrado com sucesso.</p>
        <?php } elseif ($msg == "editado") { ?>
            <p class="aviso aviso-ok">Campeonato alterado com sucesso.</p>
        <?php } elseif ($msg == "excluido") { ?>
            <p class="aviso aviso-ok">Campeonato excluído com sucesso.</p>
        <?php } elseif ($erro == "vazio") { ?>
            <p class="aviso aviso-erro">Preencha o nome e o ano do campeonato.</p>
        <?php } elseif ($erro == "salvar") { ?>
            <p class="aviso aviso-erro">Erro ao salvar o campeonato.</p>
        <?php } elseif ($erro == "excluir") { ?>
            <p class="aviso aviso-erro">Erro ao excluir o campeonato.</p>
        <?php } ?>

        <!-- ========== FORMULÁRIO (cadastrar e editar) ========== -->
        <?php if ($c['id'] == "") { ?>
            <h3 class="titulo-secao">Cadastrar campeonato</h3>
        <?php } else { ?>
            <h3 class="titulo-secao">Editar campeonato</h3>
        <?php } ?>

        <form class="form-edicao" action="../php/salvar-campeonato.php" method="post">

            <!-- O id vai escondido, e só existe quando estamos editando -->
            <?php if ($c['id'] != "") { ?>
                <input type="hidden" name="id" value="<?php echo (int) $c['id']; ?>">
            <?php } ?>

            <label for="nome">Nome do campeonato</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($c['nome']); ?>" autocomplete="off" required>

            <label for="ano">Ano</label>
            <input type="text" id="ano" name="ano" value="<?php echo htmlspecialchars($c['ano']); ?>" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" placeholder="Ex.: 2026" required>

            <!-- Os times são caixinhas (checkbox). Todas têm o nome times[], então o PHP recebe uma lista. -->
            <p class="titulo-grupo">Times pré-cadastrados</p>
            <div class="lista-times">
                <?php foreach ($times as $nome) { ?>
                    <label class="item-time">
                        <input type="checkbox" name="times[]" value="<?php echo htmlspecialchars($nome); ?>"<?php if (in_array($nome, $marcados)) { echo " checked"; } ?>>
                        <?php echo htmlspecialchars($nome); ?>
                    </label>
                <?php } ?>
            </div>

            <p class="titulo-grupo">Times cadastrados</p>
            <div class="lista-times">
                <?php $temCadastrado = false; ?>
                <?php while ($t = mysqli_fetch_assoc($timesCadastrados)) { ?>
                    <?php if (!in_array($t['nome'], $times)) { // não repete quem já está na lista de cima ?>
                        <?php $temCadastrado = true; ?>
                        <label class="item-time">
                            <input type="checkbox" name="times[]" value="<?php echo htmlspecialchars($t['nome']); ?>"<?php if (in_array($t['nome'], $marcados)) { echo " checked"; } ?>>
                            <?php echo htmlspecialchars($t['nome']); ?>
                        </label>
                    <?php } ?>
                <?php } ?>
                <?php if (!$temCadastrado) { ?>
                    <p class="nota-form">Nenhum time cadastrado ainda. <a href="cadastrar-time.php">Cadastrar time</a></p>
                <?php } ?>
            </div>

            <div class="botoes-form">
                <button type="submit" class="btn-salvar"><?php echo $c['id'] == "" ? "CADASTRAR" : "SALVAR"; ?></button>
                <?php if ($c['id'] != "") { ?>
                    <a class="btn-cancelar" href="campeonatos.php">CANCELAR</a>
                <?php } ?>
            </div>
        </form>

        <!-- ========== LISTA (visualizar, editar e excluir) ========== -->
        <h3 class="titulo-secao">Campeonatos cadastrados</h3>

        <?php if (mysqli_num_rows($listaCampeonatos) == 0) { ?>
            <p>Nenhum campeonato cadastrado.</p>
        <?php } else { ?>
            <div class="tabela-area">
                <table class="tabela">
                    <tr>
                        <th>Campeonato</th>
                        <th>Ano</th>
                        <th>Times</th>
                        <th>Ações</th>
                    </tr>
                    <?php while ($camp = mysqli_fetch_assoc($listaCampeonatos)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($camp['nome']); ?></td>
                            <td><?php echo $camp['ano']; ?></td>
                            <td>
                                <?php if ($camp['total_times'] == 0) { ?>
                                    Nenhum time
                                <?php } else { ?>
                                    <strong><?php echo $camp['total_times']; ?></strong>: <?php echo htmlspecialchars($camp['times']); ?>
                                <?php } ?>
                            </td>
                            <td class="acoes">
                                <!-- EDITAR: link que volta para esta mesma tela levando o id (?id=3) -->
                                <a class="btn-editar" href="campeonatos.php?id=<?php echo (int) $camp['id']; ?>">Editar</a>

                                <!-- EXCLUIR: formulário POST com o id escondido. O confirm() pergunta antes de enviar. -->
                                <form class="form-excluir" action="../php/excluir-campeonato.php" method="post"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este campeonato?');">
                                    <input type="hidden" name="id" value="<?php echo (int) $camp['id']; ?>">
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