<?php 
include "../../conexao.php";
session_start();

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] == 'empresa' || $_SESSION['usertype'] == 'admin') {
    header("location: ../../index.php");
    exit;
}

$id = $_SESSION['user_id'];

$resultados_por_pagina = 8;


if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
    $pagina = (int) $_GET['pagina'];
} else {
    $pagina = 1;
}

$sql_total = "SELECT COUNT(*) FROM pedidos WHERE user_id = $id";
$result_total = mysqli_query($conn, $sql_total);
if (!$result_total) {
    die('Erro na consulta SQL: ' . mysqli_error($conn));
}
$row_total = mysqli_fetch_array($result_total);
$total_pedidos = $row_total[0];
$total_paginas = ceil($total_pedidos / $resultados_por_pagina);

$offset = ($pagina - 1) * $resultados_por_pagina;

$sql = "SELECT * FROM pedidos WHERE user_id = $id LIMIT $offset, $resultados_por_pagina";
$dados = mysqli_query($conn, $sql);
if (!$dados) {
    die('Erro na consulta SQL: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/stylePedidos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>LAFTI</title>
    <style>
.card-pedido {
    border: 1px solid #ddd; 
    border-radius: 8px; 
    padding: 16px; 
    margin: 16px 0;
    background-color: #fff; 
    width: 80%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
}

.list-pedido {
    border-bottom: 1px solid #eee; 
    padding-bottom: 8px; 
    margin-bottom: 8px; 
}

.list-pedido p {
    margin: 4px 0; 
    font-size: 16px;
    color: #444;
}

.list-pedido p span {
    font-weight: normal; 
    color: #666; 
}

.list-pedido p:first-child {
    font-size: 16px; 
    font-weight: bold; 
    color: #333; 
}

.list-pedido p:not(:first-child) {
    font-size: 16px; 
    font-weight: normal;
    color: #444; 
}

div > p {
    margin: 4px 0; 
    font-size: 16px; 
    color: #444; 
}

div > p > span {
    font-weight: normal; 
    color: #666; 
}
</style>


</head>
<body>
    <nav>
        <div>
            <img src="../../icons/img-01.png" class="nav-logo" alt="LAFTI Logo">
            <p>LAFTI</p>
            
        </div>
        <div>
          <?php include "navbar.php";?>
        </div>
    </nav>

    <section class="content-principal" style="display: flex;flex-direction: column;justify-content: center;align-items: center;">
        <?php while ($linha = mysqli_fetch_assoc($dados)):
            $id_empresa = $linha['id_empresa'];
            
            $sql_empresa = "SELECT nome FROM empresas WHERE id = $id_empresa";
            $dados_empresa = mysqli_query($conn, $sql_empresa);


            $nome_empresa = $dados_empresa ? $dados_empresa->fetch_assoc()['nome'] : null;    
            ?>
            <div class='card-pedido'>
                <div class='list-pedido' style="height: 56px;">
                    <p>Estabelecimento: <span><?php echo $nome_empresa; ?></span></p>
                    <p>Preço total: <span><?= htmlspecialchars($linha['preco_total']) ?></span></p>
                    <p>Data e horário: <span><?= htmlspecialchars($linha['data_pedido']) ?></span></p>
                    <p>ID: <span><?= htmlspecialchars($linha['id']) ?></span></p>
                </div>
                <div>
                    <p>Lista: <span><?= htmlspecialchars($linha['produtos']) ?></span></p> 
                </div>
            </div>
        <?php endwhile; ?>

        <section aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= ($pagina <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($pagina > 1) ? '?pagina=' . ($pagina - 1) : '#' ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($pagina >= $total_paginas) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($pagina < $total_paginas) ? '?pagina=' . ($pagina + 1) : '#' ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </section>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
