<?php 

include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = 'user';
    $nome = $_POST['nome'] ?? '';
    $data_nascimento = $_POST['date'] ?? '2001-01-01';
    $endereco = $_POST['endereco'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $complemento = $_POST['complemento'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmsenha = $_POST['confirmsenha'] ?? '';
    $estado = 'desbloqueado';

    if ($senha !== $confirmsenha) {
        echo "<script>alert('As senhas não coincidem!'); window.location.href = 'caduser.php';</script>";
        exit; 
    }

    $dataAtual = new DateTime();
    $dataNascimento = new DateTime($data_nascimento);
    $idade = $dataAtual->diff($dataNascimento)->y;

    if ($idade < 18) {
        echo "<script>alert('Você deve ter pelo menos 18 anos para se cadastrar!'); window.location.href = 'caduser.php';</script>";
        exit;
}


$sql = "INSERT INTO `users`(`usertype`, `nome`, `date`, `endereco`, `n`, `complemento`, `telefone`, `email`, `senha`, `estado`) 
VALUES ('$user','$nome','$data_nascimento','$endereco','$numero', '$complemento', '$telefone', '$email', '$senha', '$estado')";

if (mysqli_query($conn, $sql)) {
    header("location: ../../index.php");
    //echo "Usuário inserido com sucesso!";
} else {
    //echo "Erro ao inserir usuário: " . mysqli_error($conn);
}

$conn->close();
}
?>
  
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/styleCadUser.css">
    <link rel="shortcut icon" type="imagex/png" href="icons/img-01.png">
    <title>LAFTI</title>
    <style>
        .content-principal{
            height: 120vh;
        }
    </style>
</head>
<body>
    <div class="content-principal">
        
        <form class="content-quadrado2" action="caduser.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="input2" id="gg" required>

            <label for="data">Data de nascimento:</label>
            <input type="date" name="date" class="input2" id="gg" required>

            <label for="endereco">Endereço: </label>
            <input type="text" name="endereco"  class="input2" required>
            
            <label for="numero">N°: </label>
            <input type="number" name="numero" class="input2" required>

            <label for="complemento">Complemento: </label>
            <input type="text" name="complemento" class="input2" required>

            <label for="telefone">Telefone: </label>
            <input type="text" name="telefone" class="input2" required>
            
            <label for="email">Email: </label>
            <input type="email" name="email" class="input2" required>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" class="input2" required>

            <label for="senha">Confirm. Senha: </label>
            <input type="password" name="confirmsenha" class="input2" required>
            

            <input type="submit" name="submit" class="button-cad">
         </form>

           
    </div>
    <script src="script.js"></scrip>
</body>
</html>