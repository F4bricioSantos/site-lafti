<?php  
error_reporting(0);
session_start();

include "conexao.php";

if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    $sql_user = "SELECT * FROM users WHERE `email` = '$email' AND `senha` = '$senha'";
    $result_user = mysqli_query($conn, $sql_user);

    $sql_empresas = "SELECT * FROM empresas WHERE `email` = '$email' AND `senha` = '$senha'";
    $result_empresas = mysqli_query($conn, $sql_empresas);

    $sql_admin = "SELECT * FROM administrador WHERE `email` = '$email' AND `senha` = '$senha'";
    $result_admin = mysqli_query($conn, $sql_admin);

    if (!$result_user || !$result_empresas || !$result_admin) {
        die("Erro na consulta SQL: " . mysqli_error($conn));
    }

    $row_user = mysqli_fetch_array($result_user);
    $row_empresas = mysqli_fetch_array($result_empresas);
    $row_admin = mysqli_fetch_array($result_admin);

    if ($row_user) {
        $_SESSION['email'] = $email;
        $_SESSION['usertype'] = "user";
        $_SESSION['user_id'] = $row_user['id'];
        header("location: pages/PainelUsuario/homeuser.php");
        exit;
    } if ($row_empresas) {
        $_SESSION['email'] = $email;
        $_SESSION['usertype'] = "empresa";
        $_SESSION['user_id'] = $row_empresas['id'];
        header("location: pages/PainelEmpresa/Pdutos.php");
        exit;
    } if ($row_admin) {
        $_SESSION['email'] = $email;
        $_SESSION['usertype'] = "admin";
        header("location: pages/admin/menu.php");
        exit;
    } else {
        $mensagem = "Email ou senha incorretos.";
        $_SESSION['LoginMensagem'] = $mensagem;
        header("Location: index.php");
        exit;
    }
}
