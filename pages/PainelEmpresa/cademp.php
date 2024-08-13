<?php
include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = 'empresa';
    $nome = $_POST['nome'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cnpj = $_POST['CNPJ'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmsenha = $_POST['confirmsenha'] ?? '';
    $tipo_pagamento = $_POST['tipo_pagamento'] ?? '';
    $estado = 'desbloqueado';
    $dias = 'segunda, terça, quarta, quinta,sexta, sabado';

    if ($senha !== $confirmsenha) {
        echo "<script>alert('As senhas não coincidem!'); window.location.href = 'cademp.php';</script>";
        exit;
    }


    $data_pagamento = date('Y-m-d'); 

    $sql = "INSERT INTO `empresas`(`usertype`, `nome`, `endereco`, `cnpj`, `email`, `telefone`, `senha`, `tipo_pagamento`, `data_pagamento`, `estado`, `dias`) 
            VALUES ('$user', '$nome', '$endereco', '$cnpj', '$email', '$telefone', '$senha', '$tipo_pagamento', '$data_pagamento', '$estado', '$dias')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '../../index.php';</script>";
    } else {
        echo "<script>alert('Erro ao realizar cadastro!'); window.location.href = 'cademp.php';</script>";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/styleCadEmpresa.css">
    <link rel="shortcut icon" type="imagex/png" href="icons/img-01.png">
    <title>LAFTI</title>
</head>
<body>
    <div class="content-principal">
        <form class="content-quadrado2" action="cademp.php" method="POST">
            <label for="nome">Nome</label>
            <input type="text" name="nome" class="input2" required>

            <label for="endereco">Endereço: </label>
            <input type="text" name="endereco" class="input2" required>

            <label for="CNPJ">CNPJ: </label>
            <input type="text" name="CNPJ" class="input2" required>

            <label for="email">Email: </label>
            <input type="email" name="email" class="input2" required>

            <label for="telefone">Telefone: </label>
            <input type="text" name="telefone" class="input2" required>

            <label>Senha: </label>
            <input type="password" name="senha" class="input2" required>

            <label>Confir. Senha: </label>
            <input type="password" name="confirmsenha" class="input2" required> 

            <label for="tipo_pagamento">Tipo de Pagamento:</label>
            <select name="tipo_pagamento" class="input2" required>
                <option value="mensal">Mensal R$150</option>
                <option value="anual">Anual R$1600</option>
            </select>

            <input class="button-cad" type="submit" value="Enviar" style="margin-top: 20px;">
        </form>
    </div>
    <script src="../../acetts/scripts/pagamento.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
