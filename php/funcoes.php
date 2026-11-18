<?php


function conectarBD(){

    $conexao = mysqli_connect("localhost","root","","cartao_amarelo");

    if (!$conexao) {
        die("Erro na conexão: " . mysqli_connect_error());
    }

    mysqli_set_charset($conexao,"utf8mb4");
    return $conexao;
}


function inserirTorcedor($nome, $email, $senha, $telefone, $time, $cidade){

    $conexao = conectarBD();
    $consulta = "INSERT INTO torcedores (nome, email, senha, telefone, time_clube, cidade)
                 VALUES ('$nome','$email','$senha','$telefone','$time','$cidade')";
    return mysqli_query($conexao,$consulta);
}

function retornarTorcedores(){

    $conexao = conectarBD();
    $consulta = "SELECT id, nome, email, telefone, time_clube, cidade FROM torcedores ORDER BY nome";
    $listaTorcedores = mysqli_query($conexao,$consulta);
    return $listaTorcedores;
}

function retornarTorcedorPorId($id){

    $conexao = conectarBD();
    $consulta = "SELECT id, nome, email, telefone, time_clube, cidade FROM torcedores WHERE id = $id";
    $torcedor = mysqli_query($conexao,$consulta);
    return $torcedor;
}

function retornarTorcedorPorEmail($email){

    $conexao = conectarBD();
    $consulta = "SELECT id FROM torcedores WHERE email = '$email'";
    $torcedor = mysqli_query($conexao,$consulta);
    return $torcedor;
}

function retornarLogin($email, $senha){

    $conexao = conectarBD();
    $consulta = "SELECT id, nome FROM torcedores WHERE email = '$email' AND senha = '$senha'";
    $usuario = mysqli_query($conexao,$consulta);
    return $usuario;
}

function buscarTorcedores($time, $cidade){

    $conexao = conectarBD();
    $consulta = "SELECT id, nome, telefone, time_clube, cidade FROM torcedores
                 WHERE time_clube LIKE '%$time%' AND cidade LIKE '%$cidade%' ORDER BY nome";
    $listaTorcedores = mysqli_query($conexao,$consulta);
    return $listaTorcedores;
}

function redefinirSenha($email, $novaSenha){

    $conexao = conectarBD();
    $consulta = "UPDATE torcedores SET senha = '$novaSenha' WHERE email = '$email'";
    return mysqli_query($conexao,$consulta);
}


function inserirAfiliacao($torcedor, $time, $plano, $pagamento){

    // A hora do pagamento não é enviada: o banco guarda sozinho na coluna criado_em
    $conexao = conectarBD();
    $consulta = "INSERT INTO afiliacoes (torcedor_id, time_clube, plano, pagamento)
                 VALUES ($torcedor,'$time','$plano','$pagamento')";
    return mysqli_query($conexao,$consulta);
}

function retornarAfiliacoes(){

    $conexao = conectarBD();
    $consulta = "SELECT a.id, t.nome, a.time_clube, a.plano, a.pagamento,
                        DATE_FORMAT(a.criado_em, '%d/%m/%Y %H:%i') AS hora
                 FROM afiliacoes a
                 INNER JOIN torcedores t ON t.id = a.torcedor_id
                 ORDER BY a.criado_em DESC";
    $listaAfiliacoes = mysqli_query($conexao,$consulta);
    return $listaAfiliacoes;
}

function retornarAfiliacaoPorId($id){

    $conexao = conectarBD();
    $consulta = "SELECT id, torcedor_id, time_clube, plano, pagamento,
                        DATE_FORMAT(criado_em, '%d/%m/%Y %H:%i') AS hora
                 FROM afiliacoes WHERE id = $id";
    $afiliacao = mysqli_query($conexao,$consulta);
    return $afiliacao;
}

function atualizarAfiliacao($id, $torcedor, $time, $plano, $pagamento){

    // A coluna criado_em (hora do pagamento) não muda: continua a hora em que foi registrado
    $conexao = conectarBD();
    $consulta = "UPDATE afiliacoes
                 SET torcedor_id = $torcedor, time_clube = '$time', plano = '$plano', pagamento = '$pagamento'
                 WHERE id = $id";
    return mysqli_query($conexao,$consulta);
}

function excluirAfiliacao($id){

    // O WHERE é ESSENCIAL: sem ele apagaria TODAS as afiliações!
    $conexao = conectarBD();
    $consulta = "DELETE FROM afiliacoes WHERE id = $id";
    return mysqli_query($conexao,$consulta);
}

function inserirTime($nome, $cidade, $pais, $anoFundacao){

    $conexao = conectarBD();
    $consulta = "INSERT INTO times (nome, cidade, pais, ano_fundacao)
                 VALUES ('$nome','$cidade','$pais',$anoFundacao)";
    return mysqli_query($conexao,$consulta);
}

function retornarTimes(){

    $conexao = conectarBD();
    $consulta = "SELECT id, nome, cidade, pais, ano_fundacao FROM times ORDER BY nome";
    $listaTimes = mysqli_query($conexao,$consulta);
    return $listaTimes;
}

function retornarTimePorNome($nome){

    $conexao = conectarBD();
    $consulta = "SELECT id FROM times WHERE nome = '$nome'";
    $time = mysqli_query($conexao,$consulta);
    return $time;
}

function retornarTimePorId($id){

    $conexao = conectarBD();
    $consulta = "SELECT id, nome, cidade, pais, ano_fundacao FROM times WHERE id = $id";
    $time = mysqli_query($conexao,$consulta);
    return $time;
}

function retornarTimeDuplicado($nome, $id){

    // Procura OUTRO time (id diferente) com o mesmo nome
    $conexao = conectarBD();
    $consulta = "SELECT id FROM times WHERE nome = '$nome' AND id <> $id";
    $time = mysqli_query($conexao,$consulta);
    return $time;
}

function atualizarTime($id, $nome, $cidade, $pais, $anoFundacao){

    $conexao = conectarBD();
    $consulta = "UPDATE times
                 SET nome = '$nome', cidade = '$cidade', pais = '$pais', ano_fundacao = $anoFundacao
                 WHERE id = $id";
    return mysqli_query($conexao,$consulta);
}

function excluirTime($id){

    // O WHERE é ESSENCIAL: sem ele apagaria TODOS os times!
    $conexao = conectarBD();
    $consulta = "DELETE FROM times WHERE id = $id";
    return mysqli_query($conexao,$consulta);
}

?>