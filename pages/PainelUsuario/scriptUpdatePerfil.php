<?php
 include "../../conexao.php";
 session_start();

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] !== 'user') {
    header("location: ../../index.php");
    exit;
}
$id = $_SESSION['user_id'];

 if ($conn = mysqli_connect($server, $user, $pass, $bd)) {
     // echo"deu certo";
  }else
   echo "erro";

   echo "ID do perfil recebido: " . $id; 
   
   $nome = $_POST['nome'];
   $telefone = $_POST['telefone'];
   $email = $_POST['email'];
   $endereco = $_POST['endereco'];
   $complemento = $_POST['complemento'];
   $n = $_POST['n'];
   
   $sql = "UPDATE `users` SET `nome`='$nome', `telefone`='$telefone', `email`='$email', `complemento`='$complemento', `n`='$n' WHERE id = $id";
   
   if (mysqli_query($conn, $sql)) {
       header("location: perfil.php");
       echo "perfil atualizado com sucesso!";
   } else {
       echo "Erro ao atualizar o produto: " . mysqli_error($conn);
   }
