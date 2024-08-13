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


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM pedidos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: pedidos.php");
        exit();
    } else {
        echo "Erro ao excluir o pedido: " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/stylePedido.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>LAFTI</title>
</head>
<body>
    <?php 
        $resultados_por_pagina = 4;

        $pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

        $sql_total = "SELECT COUNT(*) FROM pedidos";
        $result_total = mysqli_query($conn, $sql_total);
        $row_total = mysqli_fetch_array($result_total);
        $total_pedidos = $row_total[0];
        $total_paginas = ceil($total_pedidos / $resultados_por_pagina);

        $offset = ($pagina - 1) * $resultados_por_pagina;

        $sql = "SELECT * FROM pedidos LIMIT $offset, $resultados_por_pagina";
        $dados = mysqli_query($conn, $sql);
    ?>

    <nav>
        <div>
            <img src="../../icons/img-01.png" class="nav-logo" alt="LAFTI Logo">
            <p>LAFTI</p>
        </div>
        <div>
            <?php include "navbar.php"; ?>
        </div>
    </nav>

    <section class="content-principal" style="display: flex;flex-direction: column;justify-content: center;align-items: center;">
        <?php while ($linha = mysqli_fetch_assoc($dados)): ?>
            <div class='card-pedido' style="width: 80%;">
    <div class='info-pedido'>
        <p>CLIENTE: <span><?= htmlspecialchars($linha['user_nome']) ?></span></p>
        <p>ENDEREÇO: <span><?= htmlspecialchars($linha['user_endereco']) ?></span></p>
        <p>complemento: <span><?= htmlspecialchars($linha['user_complemento']) ?></span></p>
        <p>N°: <span><?= htmlspecialchars($linha['user_n']) ?></span></p>
    </div>
    <div class='list-pedido'>
        <p>Preço total: <span><?= htmlspecialchars($linha['preco_total']) ?></span></p>
        <p>Data e horário: <span><?= htmlspecialchars($linha['data_pedido']) ?></span></p>
        <p>ID: <span><?= htmlspecialchars($linha['id']) ?></span></p>
        <form action='' method='post'>
            <input type='hidden' name='id' value='<?= htmlspecialchars($linha['id']) ?>'>
            <input type='submit' class="btn btn-danger" value='DELETAR'>
        </form>
    </div>
    <hr>
    <div class='list-pedido'>
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
