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

function format_price($price) {
    $price = trim(str_replace(',', '.', $price));
    if (is_numeric($price)) {
        return (float)$price;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeproduto = $_POST['nomeproduto'] ?? '';
    $preco = $_POST['preco'] ?? '';

    echo "Preço recebido: " . htmlspecialchars($preco) . "<br>";

    if ($nomeproduto === '' || $preco === '') {
        echo "Nome do produto e preço são obrigatórios.";
        exit;
    }

    $preco = format_price($preco);

    echo "Preço formatado: " . htmlspecialchars($preco) . "<br>";

    if ($preco === false) {
        echo "Preço inválido.";
        exit;
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = "img/" . basename($_FILES["foto"]["name"]);
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $foto)) {
            echo "Foto enviada com sucesso.<br>";
        } else {
            echo "Erro ao enviar a foto.<br>";
            exit;
        }
    } else {
        echo "Erro no upload da foto.<br>";
        exit;
    }

    $sql = "INSERT INTO produtos (id_empresa, foto, nomeproduto, preco) VALUES ('$id', '$foto', '$nomeproduto', '$preco')";
    
    echo "SQL: " . $sql . "<br>";

    if (mysqli_query($conn, $sql)) {
        echo "Produto inserido com sucesso.<br>";
        header("Location: addProdutos.php");
        exit;
    } else {
        echo "Erro ao inserir o produto: " . mysqli_error($conn) . "<br>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/StyleAddProduttse.css">
    <title>LAFTI</title>
</head>
<body>
    
    <section class="content-principal">
        <form class="form" action="addProdutos.php" method="POST" enctype="multipart/form-data" style="margin-top:30px;margin-bottom:30px;">
             <button class="voltar"><a href="Pdutos.php" style="color:#fff;"> Voltar </a></button>
            <label for="foto">Foto</label>
            <input type="file" id="foto" name="foto" required accept="image/*">
            
            <label for="nomeproduto">Nome:</label>
            <input type="text" id="nomeproduto" name="nomeproduto" required>
            
            <label for="preco">Preço</label>
            <input type="text" id="preco" name="preco" required>
            
            <input type="submit" class="button-cad" value="Cadastrar">
        </form>  
    </section>
  
</body>
</html>
