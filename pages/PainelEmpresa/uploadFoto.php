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

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fileType = mime_content_type($_FILES['foto']['tmp_name']);
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (in_array($fileType, $allowedTypes)) {
        $foto = "img/" . basename($_FILES["foto"]["name"]);
        
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $foto)) {
            echo "Foto enviada com sucesso.<br>";
            header("location: perfil.php");
            $sql = "UPDATE empresas SET foto = '$foto' WHERE id = '$id'";
            
            if (mysqli_query($conn, $sql)) {
                echo "Foto atualizada com sucesso: $foto<br>";
                
                exit;
            } else {
                echo "Erro ao atualizar a foto: " . mysqli_error($conn) . "<br>";
            }
        } else {
            echo "Erro ao mover o arquivo enviado.<br>";
        }
    } else {
        echo "Tipo de arquivo não permitido. Apenas JPG, PNG e GIF são permitidos.<br>";
    }
} else {
   // echo "Erro no upload da foto.<br>";
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Upload de Imagem</title>
</head>
<body>
<div class="card">
  <form class="card-body" action="uploadFoto.php" method="post" enctype="multipart/form-data">
    <h5 class="card-title">enviar foto</h5>
    <input type="file" name="foto" id="foto" class="card-text">
    <input type="submit" value="Upload de Imagem" name="submit" class="btn btn-primary">
  </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>




