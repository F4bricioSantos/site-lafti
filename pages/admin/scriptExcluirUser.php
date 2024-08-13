<?php

include "../../conexao.php";

$id = $_POST["id"];
echo $id;

$sql = "DELETE FROM `users` WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("location: TabelaUsuarios.php");
} else {
    echo "Erro";
}

