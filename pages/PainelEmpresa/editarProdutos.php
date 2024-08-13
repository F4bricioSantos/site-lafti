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

$id = $_GET['id'] ?? '';
$sql = "SELECT * FROM produtos WHERE cod_produto = $id";
$dados = mysqli_query($conn, $sql);
$linha = mysqli_fetch_assoc($dados);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/styleAddProduttse.css">
    <title>LAFTI</title>
</head>
<body>
<section class="content-principal" style="height: 100vh; display:flex;justify-content: center;
    align-items: center">
    <form class="form" action="scriptEdit.php" method="POST" enctype="multipart/form-data" style="margin-top: 30px; margin-bottom: 30px;">
        <button class="voltar"><a href="Pdutos.php" style="color:#fff;"> Voltar </a></button>
        <label for="foto">Foto</label>
        <input type="file" name="foto">
        <label for="nome">Nome:</label>
        <input type="text" name="nomeproduto" required value="<?php echo htmlspecialchars($linha['nomeproduto']); ?>">
        <label for="preco">Preço</label>
        <input type="text" inputmode="numeric" name="preco" required value="<?php echo htmlspecialchars($linha['preco']); ?>">
        <div>
            <input type="submit" class="button-cad" value="Salvar">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($linha['cod_produto']); ?>">
        </div>
    </form>    
</section>
</body>
</html>
