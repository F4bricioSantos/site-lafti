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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $action = $_POST['action'] ?? null;
    $pesquisa = $_POST['busca'] ?? '';

    if ($action == 'pesquisar') {
    } elseif ($action == 'Bloquear') {
        $sql = "UPDATE `empresas` SET `estado`='bloqueado' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
           // echo "Empresa bloqueada com sucesso.";
        } else {
           // echo "Erro ao bloquear empresa: " . mysqli_error($conn);
        }
    } elseif ($action == 'Desbloquear') {
        $sql = "UPDATE `empresas` SET `estado`='desbloqueado' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Empresa desbloqueada com sucesso.";
        } else {
            echo "Erro ao desbloquear empresa: " . mysqli_error($conn);
        }
    } elseif ($action == 'Excluir') {
        echo "Usuário com ID $id excluído.";
    } else {
        echo "Nenhuma ação válida foi selecionada.";
    }
} else {
    $pesquisa = '';
}

$sql = "SELECT * FROM empresas WHERE nome LIKE '%$pesquisa%' OR id LIKE '%$pesquisa%'";
$dados = mysqli_query($conn, $sql);

$resultados_por_pagina = 4;

if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
    $pagina = (int) $_GET['pagina'];
} else {
    $pagina = 1;
}

$sql_total = "SELECT COUNT(*) FROM empresas";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_array($result_total);
$total_empresas = $row_total[0];
$total_paginas = ceil($total_empresas / $resultados_por_pagina);

$offset = ($pagina - 1) * $resultados_por_pagina;

$sql .= " LIMIT $offset, $resultados_por_pagina";
$dados = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br" style="width: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/styleuser.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>LAFTI</title>
</head>
<body style="display: inline-block; width: 100%;">
<nav>
    <div>
        <img src="../../icons/img-01.png" class="nav-logo">
        <p>LAFTI</p>
    </div>
    <div>
        <ul>
            <p>ADMINISTRADOR</p>
        </ul>
    </div>
</nav>

<section class="principal">
    <?php include "navbarLateral.php"; ?>

    <div class="container" style="margin-left: 0px;">
        <nav class="navbar bg-body">
            <div class="container">
                <form class="d-flex" role="search" action="TabelaEmpresa.php" method="POST">
                    <input class="form-control me-2" type="search" placeholder="Nome ou id" aria-label="Search" name="busca" style="height: 40px; width: 250px;">
                    <button class="btn btn-outline-success" type="submit" name="action" value="pesquisar">Pesquisar</button>
                </form>
            </div>
        </nav>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">Email</th>
                    <th scope="col">Pagamento</th>
                    <th scope="col">ultimo pagamento</th>
                    <th scope="col">Estado</th>
                    <th scope="col" style="width: 134px;">Funções</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$dados) {
                    echo "Erro na consulta: " . mysqli_error($conn);
                    exit;
                }

                while ($linha = mysqli_fetch_assoc($dados)) {
                    $id = $linha['id'];
                    $foto = !empty($linha['foto']) ? $linha['foto'] : 'img/semfoto.jfif';
                    $nome = $linha['nome'];
                    $endereco = $linha['endereco'];
                    $cnpj = $linha['cnpj'];
                    $email = $linha['email'];
                    $tipo = $linha['tipo_pagamento'];
                    $data = $linha['data_pagamento'];
                    $estado = $linha['estado'];

                    echo "<tr>
                        <td>$id</td>
                        <td><img src='../PainelEmpresa/$foto' style='width:60px; height:60px; border-radius: 100%;'></td>
                        <td>$nome</td>
                        <td>$endereco</td>
                        <td>$cnpj</td>
                        <td>$email</td>
                        <td>$tipo</td>
                        <td>$data</td>
                        <td>$estado</td>
                        <td style='width: 163px;'>
                            <form action='TabelaEmpresa.php' method='POST' style='display: inline-block;'>
                                <input type='hidden' name='id' value='$id'>
                                <input type='hidden' name='action' value='Bloquear'>
                                <input type='image' src='../../icons/bloquear.png' width='45px' alt='Bloquear' class='btn btn-warning'>
                            </form>
                            <form action='TabelaEmpresa.php' method='POST' style='display: inline-block;'>
                                <input type='hidden' name='id' value='$id'>
                                <input type='hidden' name='action' value='Desbloquear'>
                                <input type='image' src='../../icons/desbloquear.png' width='45px' alt='Desbloquear' class='btn btn-warning'>
                            </form>
                            <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#confirmar' onclick='pegar_dados($id, \"$nome\")' style='width: 46px; height: 33px; padding-left: 9px; padding-top: 2px;'>
                                <img src='../../icons/excluir.png' width='22px;' alt='Excluir'>
                            </button>
                        </td>
                    </tr>";
                }
                ?>
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

<div class="modal fade" id="confirmar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmação de exclusão</h1>
            </div>
            <div class="modal-body">
                <form action="scriptExcluirEmpresa.php" method="POST">
                    <p>Deseja realmente excluir <b id="nome_usuario">Nome do usuário</b>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                <input type="hidden" name="id" id="id_usuario" value="">
                <input type="hidden" name="action" value="Excluir">
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
