<?php
session_start();

// Se não fez login, volta para a tela de login
if (!isset($_SESSION['id'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início | Cartão Amarelo</title>
    <link rel="stylesheet" href="../assets/css/home.css">
</head>
<body>

    <header class="menu">
        <div class="logo">
            <img src="../assets/imgs/Logo_Cartão_Amarelo.png" alt="Logo do Cartão Amarelo">
        </div>

        <nav>
            <ul>
                <li><a href="noticias.html">Notícias</a></li>
                <li><a href="cadastrar.html">Cadastrar Torcedor</a></li>
                <li><a href="../php/sair.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <p class="saudacao">Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</p>

</body>
</html>