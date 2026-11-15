<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}

require "../php/conexao.php";
include "afiliacao-dados.php";

// O INNER JOIN junta cada afiliação com o torcedor dela (para mostrar o nome).
// O DATE_FORMAT deixa a data e a hora no formato 11/11/2026 22:24.
$resultado = $conexao->query(
    "SELECT a.id, t.nome, a.time_clube, a.plano, a.pagamento,
            DATE_FORMAT(a.criado_em, '%d/%m/%Y %H:%i') AS hora
     FROM afiliacoes a
     INNER JOIN torcedores t ON t.id = a.torcedor_id
     ORDER BY a.criado_em DESC"
);

// Mensagem que os arquivos da pasta php mandam pela URL (?msg=...)
$msg = $_GET['msg'] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afiliações | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>

    <?php include "menu.php"; ?>

    <main class="conteudo">
        <h3 class="titulo-secao">Afiliações</h3>

        <?php if ($msg == "afiliado") { ?>
            <p class="aviso aviso-ok">Afiliação registrada com sucesso.</p>
        <?php } elseif ($msg == "editado") { ?>
            <p class="aviso aviso-ok">Afiliação alterada com sucesso.</p>
        <?php } elseif ($msg == "excluido") { ?>
            <p class="aviso aviso-ok">Afiliação excluída com sucesso.</p>
        <?php } elseif ($msg == "erro") { ?>
            <p class="aviso aviso-erro">Não foi possível concluir a ação.</p>
        <?php } ?>

        <?php if ($resultado->num_rows == 0) { ?>
            <p>Nenhuma afiliação cadastrada.</p>
        <?php } else { ?>
            <div class="tabela-area">
                <table class="tabela">
                    <tr>
                        <th>Torcedor</th>
                        <th>Time</th>
                        <th>Plano</th>
                        <th>Pagamento</th>
                        <th>Hora do pagamento</th>
                        <th>Ações</th>
                    </tr>
                    <?php while ($a = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($a['nome']); ?></td>
                            <td><?php echo htmlspecialchars($a['time_clube']); ?></td>
                            <!-- Mostra o nome bonito do plano; se não estiver na lista, mostra o que está no banco -->
                            <td><?php echo htmlspecialchars($planos[$a['plano']] ?? $a['plano']); ?></td>
                            <td><?php echo htmlspecialchars($pagamentos[$a['pagamento']] ?? $a['pagamento']); ?></td>
                            <td><?php echo $a['hora']; ?></td>
                            <td class="acoes">
                                <!-- EDITAR: link que leva o id na URL (?id=3) -->
                                <a class="btn-editar" href="editar-afiliacao.php?id=<?php echo (int) $a['id']; ?>">Editar</a>

                                <!-- EXCLUIR: formulário POST com o id escondido. O confirm() pergunta antes de enviar. -->
                                <form class="form-excluir" action="../php/excluir-afiliacao.php" method="post"
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta afiliação?');">
                                    <input type="hidden" name="id" value="<?php echo (int) $a['id']; ?>">
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