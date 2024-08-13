<?php
session_start();
include "../../conexao.php";

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] !== 'user') {
    header("location: ../../index.php");
    exit;
}

$id_user = $_SESSION['user_id'];

function fetchProductImage($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT foto FROM produtos WHERE cod_produto = '$id'";
    $result = mysqli_query($conn, $sql);
    $foto = '';
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $foto = $row['foto'];
    }
    return $foto;
}

$id_empresa = $_POST['empresa'] ?? $_GET['empresa'] ?? '';
if (empty($id_empresa)) {
    die("ID da empresa não fornecido.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $id = intval($_POST['produto_id']);
    $nome = htmlspecialchars($_POST['produto_nome']);
    $preco = floatval($_POST['produto_preco']);
    $foto = fetchProductImage($conn, $id);

    $product = array(
        'id' => $id,
        'empresa' => $id_empresa,
        'nome' => $nome,
        'preco' => $preco,
        'foto' => $foto,
        'quantidade' => 1
    );

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $productExists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantidade'] += 1;
            $productExists = true;
            break;
        }
    }
    if (!$productExists) {
        $_SESSION['cart'][] = $product;
    }
}

$pesquisa = $_POST['busca'] ?? ($_GET['busca'] ?? '');

$id_empresa = mysqli_real_escape_string($conn, $id_empresa);
$pesquisa = mysqli_real_escape_string($conn, $pesquisa);

$itens_por_pagina = 10;
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($pagina - 1) * $itens_por_pagina;

$searchTerm = '%' . $pesquisa . '%';

$sql_total = "SELECT COUNT(*) as total FROM produtos WHERE nomeproduto LIKE '$searchTerm' AND id_empresa = '$id_empresa'";
$result_total = mysqli_query($conn, $sql_total);
if (!$result_total) {
    die("Error executing query: " . mysqli_error($conn));
}
$linha_total = mysqli_fetch_assoc($result_total);
$total_itens = $linha_total['total'];
$total_paginas = ceil($total_itens / $itens_por_pagina);

$sql = "SELECT * FROM produtos WHERE nomeproduto LIKE '$searchTerm' AND id_empresa = '$id_empresa' LIMIT $offset, $itens_por_pagina";
$dados = mysqli_query($conn, $sql);
if (!$dados) {
    die("Error executing query: " . mysqli_error($conn));
}

function truncateString($string, $length = 53) {
    if (strlen($string) > $length) {
        return substr($string, 0, $length) . '...';
    } else {
        return $string;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/styleHomeProduto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <title>LAFTI</title>
    <style>
        .btn-cart {
            background-color: transparent;
            border: none;
            padding: 0;
        }
        .btn-cart .fas {
            font-size: 24px;
            color: #fff;
        }

        .link-home {
            color: #fff;
        }
        .link-home .fas {
            margin: 0 10px;
            font-size: 24px;
            color: #fff;

        }
    </style>
    <script>
        function showAlert() {
            alert("Você está bloqueado. Entre em contato com a LAFTI pelo email.");
        }
    </script>
</head>
<body>
    <?php
    $sql = "SELECT * FROM empresas WHERE id = '$id_empresa'";
    $dados_empresa = mysqli_query($conn, $sql);
    if (!$dados_empresa) {
        die("Error executing query: " . mysqli_error($conn));
    }
    while ($linha = mysqli_fetch_assoc($dados_empresa)) {
        $foto = !empty($linha['foto']) ? $linha['foto'] : 'img/semfoto.jfif';
        $nome = $linha['nome'];
        $telefone = $linha['telefone'];
    }
    ?>

<nav>
    <div>
        <img src="../PainelEmpresa/<?php echo $foto; ?>" style="border-radius: 10%;" class="nav-logo">
        <p><?php echo $nome; ?><br><?php echo $telefone; ?></p>
    </div>
    <div>
        <form class="d-flex" role="search" action="homeprodutos.php" method="POST" style="display: flex;align-items: center;">
            <input type="text" placeholder="PESQUISE EM LAFT.COM.BR" aria-label="Search" name="busca" value="<?php echo htmlspecialchars($pesquisa); ?>">
            <button class="btn btn-success" type="submit">Pesquisar</button>
            <input type="hidden" name="empresa" value="<?php echo htmlspecialchars($id_empresa); ?>">
        </form>
        <a href="homeuser.php" class="link-home">
            <i class="fas fa-home"></i>
        </a>
        <form action='carrinho.php' method='post'>
            <input type='hidden' name='empresa' value='<?php echo $id_empresa; ?>'>
            <button type='submit' class="btn-cart">
                <i class="fas fa-shopping-cart"></i>
            </button>
        </form>
    </div>
</nav>

<section class="principal">
    <section class="content-wrapper">
        <section class="content">
          <?php
          $sql_user = "SELECT estado FROM users WHERE id = $id_user";
          $result_user = mysqli_query($conn, $sql_user);

          if ($result_user && mysqli_num_rows($result_user) > 0) {
              $row_user = mysqli_fetch_assoc($result_user);
              $status_bloqueio = $row_user['estado'];
          } else {
              echo "Nenhum registro encontrado.";
              $status_bloqueio = 'desbloqueado'; 
          }

          if (mysqli_num_rows($dados) > 0) {
              while ($row = mysqli_fetch_assoc($dados)) {
                  $id = $row['cod_produto'];
                  $foto = !empty($row['foto']) ? $row['foto'] : 'img/semfoto.jfif';
                  $produto = htmlspecialchars($row['nomeproduto']);
                  $preco = number_format($row['preco'], 2, ',', '.');

                  echo "<div class='card-produto'>
                          <img src='../PainelEmpresa/$foto' class='product-image'>
                          <span class='nome-produto'>$produto</span>
                          <div style='display: flex;'>
                              <span class='product-price'>R$$preco</span>
                              <form method='POST' action='homeprodutos.php'>
                                  <input type='hidden' name='produto_id' value='$id'>
                                  <input type='hidden' name='produto_nome' value='$produto'>
                                  <input type='hidden' name='produto_preco' value='{$row['preco']}'>
                                  <input type='hidden' name='empresa' value='$id_empresa'>";

                  if ($status_bloqueio == 'bloqueado') {
                      echo "<button class='button-hover-background' onclick='showAlert()' style='background-color: #6c757d;cursor: not-allowed;border-radius: 10px;'></button>";
                  } elseif ($status_bloqueio == 'desbloqueado') {
                      echo "<button type='submit' class='button-hover-background' name='add_to_cart'></button>";
                  }

                  echo "       </form>
                          </div>
                        </div>";
              }
          } else {
              echo "Nenhum produto encontrado.";
          }

          mysqli_close($conn);
          ?> 
        </section>
    </section>
    <section class="pagination-wrapper">
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
</section>


<?php include "../footer.php";?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</body>
</html>
