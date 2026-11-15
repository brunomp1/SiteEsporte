<?php if ($resultado->num_rows == 0) { ?>
    <p>Nenhum torcedor encontrado.</p>
<?php } else { ?>
    <div class="tabela-area">
        <table class="tabela">
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Time</th>
                <th>Cidade</th>
            </tr>
            <?php while ($t = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($t['nome']); ?></td>
                    <td><?php echo htmlspecialchars($t['telefone']); ?></td>
                    <td><?php echo htmlspecialchars($t['time_clube']); ?></td>
                    <td><?php echo htmlspecialchars($t['cidade']); ?></td>
              <td class="acoes">
                        <!-- EDITAR: é só um link. Leva para a tela de edição levando o id na URL (?id=3) -->
                        <a class="btn-editar" href="editar-torcedor.php?id=<?php echo (int) $t['id']; ?>">Editar</a>

                        <!-- EXCLUIR: é um formulário POST, com o id escondido.
                             O confirm() abre a janelinha "OK / Cancelar" antes de enviar. -->
                        <form class="form-excluir" action="../php/excluir.php" method="post"
                              onsubmit="return confirm('Tem certeza que deseja excluir este torcedor?');">
                            <input type="hidden" name="id" value="<?php echo (int) $t['id']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>