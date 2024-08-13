<?php

include "../../conexao.php";

$id = $_POST["id"];
echo $id;

$sql = "DELETE FROM `empresas` WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("location: TabelaEmpresa.php");
} else {
    echo "Erro";
}

