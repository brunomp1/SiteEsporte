<?php
// Formulário usado por afiliar.php (nova) e editar-afiliacao.php (editar).
// Antes de incluir, defina:
//   $acao       = arquivo PHP que vai receber o formulário
//   $botao      = texto do botão de salvar
//   $a          = dados da afiliação (campos vazios quando é uma nova)
//   $torcedores = resultado do banco com os torcedores para escolher
?>
<form class="form-edicao" action="<?php echo $acao; ?>" method="post">

    <!-- O id vai escondido, e só existe quando estamos editando -->
    <?php if ($a['id'] != "") { ?>
        <input type="hidden" name="id" value="<?php echo (int) $a['id']; ?>">
    <?php } ?>

    <label for="torcedor">Torcedor</label>
    <select id="torcedor" name="torcedor" required>
        <option value="">Selecione o torcedor</option>
        <?php while ($t = $torcedores->fetch_assoc()) { ?>
            <option value="<?php echo (int) $t['id']; ?>"<?php if ($t['id'] == $a['torcedor_id']) { echo " selected"; } ?>>
                <?php echo htmlspecialchars($t['nome'] . " (" . $t['email'] . ")"); ?>
            </option>
        <?php } ?>
    </select>

    <label for="time">Time</label>
    <select id="time" name="time" required>
        <option value="">Selecione o time</option>
        <?php foreach ($times as $nome) { ?>
            <option value="<?php echo htmlspecialchars($nome); ?>"<?php if ($nome == $a['time_clube']) { echo " selected"; } ?>>
                <?php echo htmlspecialchars($nome); ?>
            </option>
        <?php } ?>
    </select>

    <label for="plano">Plano</label>
    <select id="plano" name="plano" required>
        <option value="">Selecione o plano</option>
        <?php foreach ($planos as $valor => $nome) { ?>
            <option value="<?php echo $valor; ?>"<?php if ($valor == $a['plano']) { echo " selected"; } ?>>
                <?php echo $nome; ?>
            </option>
        <?php } ?>
    </select>

    <label for="pagamento">Forma de pagamento</label>
    <select id="pagamento" name="pagamento" required>
        <option value="">Selecione a forma de pagamento</option>
        <?php foreach ($pagamentos as $valor => $nome) { ?>
            <option value="<?php echo $valor; ?>"<?php if ($valor == $a['pagamento']) { echo " selected"; } ?>>
                <?php echo $nome; ?>
            </option>
        <?php } ?>
    </select>

    <!-- A hora do pagamento não é digitada: o banco guarda sozinho (coluna criado_em) -->
    <?php if ($a['hora'] != "") { ?>
        <p class="nota-form">Hora do pagamento: <strong><?php echo $a['hora']; ?></strong></p>
    <?php } else { ?>
        <p class="nota-form">A data e a hora do pagamento são guardadas automaticamente ao salvar.</p>
    <?php } ?>

    <div class="botoes-form">
        <button type="submit" class="btn-salvar"><?php echo $botao; ?></button>
        <a class="btn-cancelar" href="afiliacoes.php">CANCELAR</a>
    </div>
</form>