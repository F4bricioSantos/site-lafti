<?php
include "../../conexao.php";

$id = mysqli_real_escape_string($conn, $_POST["id"]);

$sql = "DELETE FROM `produtos` WHERE cod_produto = $id";

if (mysqli_query($conn, $sql)) {
    header("location: TabelaProdutos.php");
} else {
    echo "Erro ao excluir o produto.";
}

mysqli_close($conn);

