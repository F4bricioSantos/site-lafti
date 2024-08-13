<?php
include "../../conexao.php";
session_start();

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] == 'user' || $_SESSION['usertype'] == 'empresa') {
    header("location: ../../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/styleuser.css">    
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>LAFTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav>
        <div>
            <img src="../../icons/img-01.png" class="nav-logo">
            <p>LAFTI</p>
        </div>
        <div>
            <p>ADMINISTRADOR</p>
        </div>
    </nav>

    <section class="principal">
        <?php include "navbarLateral.php"; ?>

        <div class="container" style="margin-left: 0px;">
            <?php 
            

            $resultados_por_pagina = 5;

            if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
                $pagina = (int) $_GET['pagina'];
            } else {
                $pagina = 1;
            }

            $sql = "SELECT * FROM historico";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST['busca'])) {
                    $termo_busca = $_POST['busca'];
                    $sql = " WHERE id LIKE '%$termo_busca%'";
                }
            }

            $sql_total = "SELECT COUNT(*) FROM historico";
            $result_total = mysqli_query($conn, $sql_total);
            $row_total = mysqli_fetch_array($result_total);
            $total_pedidos = $row_total[0];
            $total_paginas = ceil($total_pedidos / $resultados_por_pagina);

            $offset = ($pagina - 1) * $resultados_por_pagina;

            $sql .= " LIMIT $offset, $resultados_por_pagina";

            $dados = mysqli_query($conn, $sql);
            ?>

            <nav class="navbar bg-body">
                <div class="container">
                    <form class="d-flex" role="search" action="TabelaHistorico.php" method="POST">
                        <input class="form-control me-2" type="search" placeholder="id de compra" aria-label="Search" name="busca" style="height: 40px; width: 250px;">
                        <button class="btn btn-outline-success" type="submit">Pesquisar</button>
                    </form>
                </div>
            </nav>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID Pedido</th>
                        <th scope="col">ID Empresa</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Complemento</th>
                        <th scope="col">N°</th>
                        <th scope="col">Lista de Produtos</th>
                        <th scope="col">Preço Total</th>
                        <th scope="col">Data do Pedido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($linha = mysqli_fetch_assoc($dados)): ?>
                        <tr>
                            <td><?= $linha['id'] ?></td>
                            <td><?= $linha['id_empresa'] ?></td>
                            <td><?= $linha['user_nome'] ?></td>
                            <td><?= $linha['user_endereco'] ?></td>
                            <td><?= $linha['user_complemento'] ?></td>
                            <td><?= $linha['user_n'] ?></td>
                            <td><?= $linha['produtos'] ?></td>
                            <td><?= $linha['preco_total'] ?></td>
                            <td><?= $linha['data_pedido'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>


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
        </div>
    </section>

  <script type="text/javascript">
    function pegar_dados(id, nome) {
        document.getElementById('nome_usuario').innerHTML = nome;
        document.getElementById('id_usuario').value = id;
    }
  </script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
