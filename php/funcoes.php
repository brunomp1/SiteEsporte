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

    // Sem where da ruim no codigo
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
}// ---------------- CAMPEONATOS ----------------

function inserirCampeonato($nome, $ano, $listaTimes){

    $conexao = conectarBD();
    // mysqli_real_escape_string deixa o texto seguro para entrar no SQL
    $nome = mysqli_real_escape_string($conexao,$nome);
    $consulta = "INSERT INTO campeonatos (nome, ano) VALUES ('$nome',$ano)";
    $resultado = mysqli_query($conexao,$consulta);

    // id do campeonato que acabou de ser criado: serve para ligar os times a ele
    $idNovo = mysqli_insert_id($conexao);
    salvarTimesDoCampeonato($idNovo, $listaTimes);

    return $resultado;
}

function atualizarCampeonato($id, $nome, $ano, $listaTimes){

    $conexao = conectarBD();
    $nome = mysqli_real_escape_string($conexao,$nome);
    $consulta = "UPDATE campeonatos SET nome = '$nome', ano = $ano WHERE id = $id";
    $resultado = mysqli_query($conexao,$consulta);

    salvarTimesDoCampeonato($id, $listaTimes);

    return $resultado;
}

function salvarTimesDoCampeonato($idCampeonato, $listaTimes){

    $conexao = conectarBD();

    // Apaga os times antigos do campeonato e grava de novo os que foram marcados.
    // Assim a mesma função serve para cadastrar e para editar.
    mysqli_query($conexao,"DELETE FROM campeonato_times WHERE campeonato_id = $idCampeonato");

    foreach ($listaTimes as $time) {
        $time = mysqli_real_escape_string($conexao,$time);
        mysqli_query($conexao,"INSERT INTO campeonato_times (campeonato_id, time_nome) VALUES ($idCampeonato,'$time')");
    }
}

function retornarCampeonatos(){

    $conexao = conectarBD();
    // O LEFT JOIN traz o campeonato mesmo que ele ainda não tenha times.
    // O GROUP_CONCAT junta os nomes dos times em uma linha só.
    $consulta = "SELECT c.id, c.nome, c.ano, COUNT(ct.id) AS total_times,
                        GROUP_CONCAT(ct.time_nome ORDER BY ct.time_nome SEPARATOR ', ') AS times
                 FROM campeonatos c
                 LEFT JOIN campeonato_times ct ON ct.campeonato_id = c.id
                 GROUP BY c.id, c.nome, c.ano
                 ORDER BY c.ano DESC, c.nome";
    $listaCampeonatos = mysqli_query($conexao,$consulta);
    return $listaCampeonatos;
}

function retornarCampeonatoPorId($id){

    $conexao = conectarBD();
    $consulta = "SELECT id, nome, ano FROM campeonatos WHERE id = $id";
    $campeonato = mysqli_query($conexao,$consulta);
    return $campeonato;
}

function retornarTimesDoCampeonato($id){

    $conexao = conectarBD();
    $consulta = "SELECT time_nome FROM campeonato_times WHERE campeonato_id = $id";
    $listaTimes = mysqli_query($conexao,$consulta);
    return $listaTimes;
}

function excluirCampeonato($id){

    $conexao = conectarBD();
    // Primeiro apaga os times do campeonato, depois o próprio campeonato
    mysqli_query($conexao,"DELETE FROM campeonato_times WHERE campeonato_id = $id");

    // O WHERE é ESSENCIAL: sem ele apagaria TODOS os campeonatos!
    return mysqli_query($conexao,"DELETE FROM campeonatos WHERE id = $id");
}

// ---------------- COMENTÁRIOS (COMUNIDADE) ----------------

function inserirComentario($torcedor, $campeonato, $texto){

    $conexao = conectarBD();
    $texto = mysqli_real_escape_string($conexao,$texto);

    // Sem campeonato escolhido (0), o comentário é geral: guarda NULL no banco
    if ($campeonato == 0) {
        $campeonato = "NULL";
    }

    $consulta = "INSERT INTO comentarios (torcedor_id, campeonato_id, texto)
                 VALUES ($torcedor,$campeonato,'$texto')";
    return mysqli_query($conexao,$consulta);
}

function retornarComentarios(){

    $conexao = conectarBD();
    // O INNER JOIN traz o nome de quem comentou.
    // O LEFT JOIN traz o campeonato, mas o comentário aparece mesmo sem campeonato.
    $consulta = "SELECT c.id, c.torcedor_id, c.texto, t.nome, camp.nome AS campeonato,
                        DATE_FORMAT(c.criado_em, '%d/%m/%Y %H:%i') AS hora
                 FROM comentarios c
                 INNER JOIN torcedores t ON t.id = c.torcedor_id
                 LEFT JOIN campeonatos camp ON camp.id = c.campeonato_id
                 ORDER BY c.criado_em DESC, c.id DESC
                 LIMIT 50";
    $listaComentarios = mysqli_query($conexao,$consulta);
    return $listaComentarios;
}

function excluirComentario($id, $torcedor){

    $conexao = conectarBD();
    // O "AND torcedor_id" garante que cada pessoa só apaga os PRÓPRIOS comentários
    $consulta = "DELETE FROM comentarios WHERE id = $id AND torcedor_id = $torcedor";
    return mysqli_query($conexao,$consulta);
}

?>