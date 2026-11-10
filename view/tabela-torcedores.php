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
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>