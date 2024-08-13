<?php
include "../../conexao.php";

session_start();

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] == 'user' || $_SESSION['usertype'] == 'admin') {
    header("location: ../../index.php");
    exit;
}

$id = $_SESSION['user_id'];

if (isset($_POST['nome'], $_POST['email'], $_POST['endereco'], $_POST['telefone'], $_POST['cnpj'])) {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $endereco = mysqli_real_escape_string($conn, $_POST['endereco']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    $cnpj = mysqli_real_escape_string($conn, $_POST['cnpj']);
    $aberto = mysqli_real_escape_string($conn, $_POST['aberto']);
    $fechado = mysqli_real_escape_string($conn, $_POST['fechado']);
    $dias = mysqli_real_escape_string($conn, $_POST['dias']);

    $sql = "UPDATE `empresas` SET `nome`='$nome', `email`='$email', `endereco`='$endereco', `telefone`='$telefone', `cnpj`='$cnpj', `aberto`='$aberto', `fechado`='$fechado', `dias`='$dias' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("location: perfil.php");
        exit;
    } else {
        echo "Erro ao atualizar o perfil: " . mysqli_error($conn);
    }
} else {
    echo "Dados do formulário incompletos.";
}

mysqli_close($conn);

