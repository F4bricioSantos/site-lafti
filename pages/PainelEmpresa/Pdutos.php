<?php
session_start();
include "../../conexao.php";

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] == 'user' || $_SESSION['usertype'] == 'admin') {
    header("location: ../../index.php");
    exit;
}

$id = $_SESSION['user_id'];

$sql = "SELECT * FROM empresas WHERE id = '$id'";
$dados = mysqli_query($conn, $sql);
$linha = mysqli_fetch_assoc($dados);
$estado = $linha['estado'];

if ($estado === 'bloqueado') {
    $classeBotao = 'inclicavel';
    $atributoDisabled = 'disabled';
    $link = '#';
} else {
    $classeBotao = 'clicavel';
    $atributoDisabled = '';
    $link = 'addProdutos.php';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/styleHomeProduto.css">    
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>LAFTI</title>
    <style>
        .clicavel {
            background-color: green;
            color: white;
            cursor: pointer;
        }
        .inclicavel {
            background-color: grey;
            color: white;
            cursor: not-allowed;
        }
    </style>
    <script type="text/javascript">
        function mostrarAviso() {
            alert("Você está bloqueado e não receberá pedidos. Entre em contato com a LAFTI pelo email.");
        }
    </script>
</head>
<body>
    <nav>
        <div>
            <img src="../../icons/img-01.png" class="nav-logo">
            <p>LAFTI</p>
        </div>
        <div>
        <?php include "navbar.php"; ?>
        </div>
    </nav>

    <?php
    $pesquisa = $_POST['busca'] ?? '';

    $itens_por_pagina = 6;
    $pagina = $_GET['pagina'] ?? 1;
    $offset = ($pagina - 1) * $itens_por_pagina;

    $sql_total = "SELECT COUNT(*) as total FROM produtos WHERE nomeproduto LIKE '%$pesquisa%' AND id_empresa = '$id'";
    $resultado_total = mysqli_query($conn, $sql_total);
    $linha_total = mysqli_fetch_assoc($resultado_total);
    $total_itens = $linha_total['total'];
    $total_paginas = ceil($total_itens / $itens_por_pagina);

    $sql = "SELECT * FROM produtos WHERE nomeproduto LIKE '%$pesquisa%' AND id_empresa = '$id' LIMIT $offset, $itens_por_pagina";
    $dados = mysqli_query($conn, $sql);
    ?>

    <div class="container">
        <nav class="navbar bg-body">
            <div class="container">
                <form class="d-flex" role="search" action="Pdutos.php" method="POST">
                    <input class="form-control me-2" type="search" placeholder="Produto" aria-label="Search" name="busca" style="height: 40px; width: 250px;">
                    <button class="btn btn-outline-success" type="submit" style="width: 89px;">Pesquisar</button>
                </form>
                <a href="<?php echo $link; ?>" <?php echo $atributoDisabled ? 'class="inclicavel"' : ''; ?> onclick="<?php echo $atributoDisabled ? 'mostrarAviso(); return false;' : ''; ?>">
                    <button class="btn btn-success <?php echo $classeBotao; ?>" style="width: 89px;" <?php echo $atributoDisabled; ?>>
                        Adicionar
                    </button>
                </a>
            </div>
        </nav>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Imagem</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Preço</th>
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
                    $cod_produto = $linha['cod_produto'];
                    $foto = !empty($linha['foto']) ? $linha['foto'] : 'img/semfoto.jfif';
                    $produto = $linha['nomeproduto'];
                    $preco = $linha['preco'];

                    $botaoEditarClasse = $classeBotao;
                    $botaoEditarAtributo = $atributoDisabled;
                    $linkEditar = $estado === 'bloqueado' ? '#' : 'editarProdutos.php?id=' . $cod_produto;
                    $onclickEditar = $estado === 'bloqueado' ? 'mostrarAviso(); return false;' : '';

                    echo "<tr>
                            <th><img src='$foto' width='50px' height='50px'></th>
                            <td>$produto</td>
                            <td>R$$preco</td>
                            <td>
                                <a href='$linkEditar' class='btn btn-success btn-sm $botaoEditarClasse' $botaoEditarAtributo onclick='$onclickEditar'>Editar</a>
                                <a href='#' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmar' onclick='pegar_dados($cod_produto, \"$produto\")'>Excluir</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <section aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php if ($pagina <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="<?php if ($pagina > 1) echo '?pagina=' . ($pagina - 1); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                for ($i = 1; $i <= $total_paginas; $i++) {
                    $active = ($i == $pagina) ? 'active' : '';
                    echo "<li class='page-item $active'><a class='page-link' href='?pagina=$i'>$i</a></li>";
                }
                ?>
                <li class="page-item <?php if ($pagina >= $total_paginas) echo 'disabled'; ?>">
                    <a class="page-link" href="<?php if ($pagina < $total_paginas) echo '?pagina=' . ($pagina + 1); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </section>
    </div>

    <div class="modal fade" id="confirmar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmação de exclusão</h1>
                </div>
                <div class="modal-body">
                    <form action="scriptExcluir.php" method="POST">
                        <p>Deseja realmente excluir <b id="nome_produto"> Nome do produto</b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                    <input type="hidden" name="nome" id="cod_produto_1" value="">
                    <input type="hidden" name="id" id="cod_produto" value="">
                    <input type="submit" class="btn btn-danger" value="Sim">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function pegar_dados(id, nome) {
            document.getElementById('nome_produto').innerHTML = nome;
            document.getElementById('cod_produto_1').value = nome;
            document.getElementById('cod_produto').value = id;
        }
    </script>
    <script src="/acetts/scripts/addprodutos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
