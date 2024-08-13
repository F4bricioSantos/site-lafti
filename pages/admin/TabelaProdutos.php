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
<body style="display: inline-block; width: 100%;">
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
            include "../../conexao.php";

            $resultados_por_pagina = 5;

            if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
                $pagina = (int) $_GET['pagina'];
            } else {
                $pagina = 1;
            }

            $sql = "SELECT * FROM produtos";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST['busca'])) {
                    $termo_busca = $_POST['busca'];
                    $sql .= " WHERE cod_produto LIKE '%$termo_busca%' OR nomeproduto LIKE '%$termo_busca%'";
                }
            }

            $sql_total = "SELECT COUNT(*) FROM produtos";
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
                    <form class="d-flex" role="search" action="TabelaProdutos.php" method="POST">
                        <input class="form-control me-2" type="search" placeholder="id ou nome do produto" aria-label="Search" name="busca" style="height: 40px; width: 250px;">
                        <button class="btn btn-outline-success" type="submit">Pesquisar</button>
                    </form>
                </div>
            </nav>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID Produto</th>
                        <th scope="col">ID Empresa</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Funções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($linha = mysqli_fetch_assoc($dados)): ?>
                        <tr>
                            <td><?= $linha['cod_produto'] ?></td>
                            <td><?= $linha['id_empresa'] ?></td>
                            <td><img src="../PainelEmpresa/<?= !empty($linha['foto']) ? $linha['foto'] : 'img/semfoto.jfif'; ?>" style="width: 70px;border-radius: 5px;"></td>
                            <td><?= $linha['nomeproduto'] ?></td>
                            <td>R$<?= $linha['preco'] ?></td>
                            <td>
                            <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#confirmar' onclick='pegar_dados(<?= $linha["cod_produto"] ?>, "<?= $linha["nomeproduto"] ?>")' style='padding-left: 12px;padding-top: 5px;padding-bottom: 5px;'>
                                <img src='../../icons/excluir.png' width='30px;' alt='Excluir'>
                            </button>
                            </td>
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
    
    <!-- Modal -->
    <div class="modal fade" id="confirmar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmação de exclusão</h1>
                </div>
                <div class="modal-body">
                    <form action="scriptExcluirProdutos.php" method="POST">
                        <p>Deseja realmente excluir <b id="nome_usuario">Nome do usuário</b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                    <input type="hidden" name="id" id="id_usuario" value="">
                    <input type="submit" class="btn btn-danger" value="Sim">
                    </form>
                </div>
            </div>
        </div>
    </div>

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
