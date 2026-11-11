<?php
require "../php/conexao.php";

$mensagem = "";

if (!empty($_POST['email']) && !empty($_POST['nova_senha'])) {

    $email = trim($_POST['email']);
    $senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

    $stmt = $conexao->prepare("UPDATE torcedores SET senha = ? WHERE email = ?");
    $stmt->bind_param("ss", $senha, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $mensagem = "Senha redefinida com sucesso!";
    } else {
        $mensagem = "Email não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir senha | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

    <main class="fundo">
        <form class="forms" method="post">
            <h2>Redefinir senha</h2>

            <?php if ($mensagem != "") { ?>
                <p class="mensagem-erro" style="display: block;"><?php echo $mensagem; ?></p>
            <?php } ?>

            <input type="email" name="email" placeholder="Email do torcedor" required>
            <input type="password" name="nova_senha" placeholder="Nova senha" required>

            <button type="submit" class="btn-entrar">REDEFINIR SENHA</button>

            <div class="links-linha">
                <a href="login.html">Voltar ao login</a>
            </div>
        </form>
    </main>

</body>
</html>