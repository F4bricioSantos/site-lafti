<?php
include "../../conexao.php";
$id = $_POST['id'];

$sql = "DELETE FROM `produtos` WHERE cod_produto = $id";

if (mysqli_query($conn, $sql)) {
    header("location: Pdutos.php");
    echo "Produto excluído com sucesso!";
} else {
    echo "Erro ao excluir o produto: " . mysqli_error($conn);
}
