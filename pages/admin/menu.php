<?php
include "../../conexao.php";

$sql_usuarios = "SELECT COUNT(*) AS total FROM users";
$resultado_usuarios = mysqli_query($conn, $sql_usuarios);
$total_usuarios = 0;
if ($resultado_usuarios) {
    $linha = mysqli_fetch_assoc($resultado_usuarios);
    $total_usuarios = $linha['total'];
} else {
    $total_usuarios = "Erro: " . mysqli_error($conn);
}

$sql_empresas = "SELECT COUNT(*) AS total FROM empresas";
$resultado_empresas = mysqli_query($conn, $sql_empresas);
$total_empresas = 0;
if ($resultado_empresas) {
    $linha = mysqli_fetch_assoc($resultado_empresas);
    $total_empresas = $linha['total'];
} else {
    $total_empresas = "Erro: " . mysqli_error($conn);
}

$sql_produtos = "SELECT COUNT(*) AS total FROM produtos";
$resultado_produtos = mysqli_query($conn, $sql_produtos);
$total_produtos = 0;
if ($resultado_produtos) {
    $linha = mysqli_fetch_assoc($resultado_produtos);
    $total_produtos = $linha['total'];
} else {
    $total_produtos = "Erro: " . mysqli_error($conn);
}

$sql_compras = "SELECT COUNT(*) AS total FROM historico";
$resultado_compras = mysqli_query($conn, $sql_compras);
$total_compras = 0;
if ($resultado_compras) {
    $linha = mysqli_fetch_assoc($resultado_compras);
    $total_compras = $linha['total'];
} else {
    $total_compras = "Erro: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../acetts/css/styleMenop.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>


<body>
    <nav>
        <div>
            <img src="../../icons/img-01.png" class="nav-logo" alt="Logo">
            <p>LAFTI</p>
        </div>
        <div>
            <p>ADMINISTRADOR</p>
        </div>
    </nav>
    <div class="side-navbar">
        <?php include "navbarLateral.php"; ?>
    </div>
    
    <div class="main-content" >
        <div class="header">
            <div class="title">Bem-vindo ao Painel</div>
         </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h3>Usuários</h3>
                    <div class="indicator">
                        <div class="icon"><i class='bx bx-user'></i></div>
                        <div class="value"><?php echo htmlspecialchars($total_usuarios); ?></div>
                        <div class="description">Total de Usuários</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h3>Empresas</h3>
                    <div class="indicator">
                        <div class="icon"><i class='bx bx-building'></i></div>
                        <div class="value"><?php echo htmlspecialchars($total_empresas); ?></div>
                        <div class="description">Total de Empresas</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h3>Produtos</h3>
                    <div class="indicator">
                        <div class="icon"><i class='bx bx-package'></i></div>
                        <div class="value"><?php echo htmlspecialchars($total_produtos); ?></div>
                        <div class="description">Total de Produtos</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h3>Compras</h3>
                    <div class="indicator">
                        <div class="icon"><i class='bx bx-cart'></i></div>
                        <div class="value"><?php echo htmlspecialchars($total_compras); ?></div>
                        <div class="description">Total de Compras</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
