<?php
include "../../conexao.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = intval($_POST['id']);
$nomeproduto = mysqli_real_escape_string($conn, $_POST['nomeproduto']);
$preco = mysqli_real_escape_string($conn, $_POST['preco']);

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_type = $_FILES['foto']['type'];

    $tipos_aceitos = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($foto_type, $tipos_aceitos)) {
        exit('Tipo de arquivo não aceito. Apenas JPEG, PNG e WebP são permitidos.');
    }

    $destino = "img/" . basename($foto);
    if (move_uploaded_file($foto_tmp, $destino)) {
        $sql = "UPDATE produtos SET foto='$destino', nomeproduto='$nomeproduto', preco='$preco' WHERE cod_produto = $id";
    } else {
        exit('Erro ao mover o arquivo para o destino.');
    }
} else {
    $sql_imagem = "SELECT foto FROM produtos WHERE cod_produto = $id";
    $result_imagem = mysqli_query($conn, $sql_imagem);
    
    if ($result_imagem) {
        $linha_imagem = mysqli_fetch_assoc($result_imagem);
        $foto = $linha_imagem['foto'];

        $sql = "UPDATE produtos SET nomeproduto='$nomeproduto', preco='$preco' WHERE cod_produto = $id";
    } else {
        exit('Erro ao buscar a imagem existente: ' . mysqli_error($conn));
    }
}

if (mysqli_query($conn, $sql)) {
    echo "Produto atualizado com sucesso.";
    header("location: Pdutos.php");
} else {
    exit('Erro ao atualizar o produto: ' . mysqli_error($conn));
}

mysqli_close($conn);
?>
