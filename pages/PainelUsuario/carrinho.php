<?php
include "../../conexao.php";
session_start();

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'empresa') {
    header("location: ../../index.php");
    exit;
}

$id = $_SESSION['user_id'];
$id_empresa = $_POST['empresa'] ?? '';

if (isset($_SESSION['empresa_atual']) && $_SESSION['empresa_atual'] != $id_empresa) {
    unset($_SESSION['cart']);
}
$_SESSION['empresa_atual'] = $id_empresa;

$sql_user = "SELECT * FROM users WHERE id = $id";
$dados = mysqli_query($conn, $sql_user);

if (!$dados) {
    die("Query failed: " . mysqli_error($conn));
}

$linha = mysqli_fetch_assoc($dados);

if (!$linha) {
    die("No user found with id: $id");
}

$nome = mysqli_real_escape_string($conn, $linha['nome']);
$endereco = mysqli_real_escape_string($conn, $linha['endereco']);
$n = mysqli_real_escape_string($conn, $linha['n']);
$complemento = mysqli_real_escape_string($conn, $linha['complemento']);
$telefone = mysqli_real_escape_string($conn, $linha['telefone']);
$empresa = mysqli_real_escape_string($conn, $id_empresa);

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $produtos = array();
        $preco_total = 0.0;

        foreach ($_SESSION['cart'] as $item) {
            $item_id = $item['id'];
            $quantidade = isset($_POST['quantidade'][$item_id]) ? intval($_POST['quantidade'][$item_id]) : 0;

            if ($quantidade > 0) {
                $_SESSION['cart'][$item_id]['quantidade'] = $quantidade;
                $nome_produto = mysqli_real_escape_string($conn, $item['nome']);
                $preco = floatval($item['preco']);
                $produtos[] = "$nome_produto (x$quantidade)";
                $preco_total += $preco * $quantidade;
            } else {
                unset($_SESSION['cart'][$item_id]);
            }
        }

        $produtos = implode(", ", $produtos);
        $preco_total = number_format($preco_total, 2, '.', '');

        $sql_pedido = "INSERT INTO pedidos (user_id, id_empresa, user_nome, user_endereco, user_n, user_complemento, telefone, produtos, preco_total) 
                      VALUES ('$id', '$empresa', '$nome', '$endereco', '$n', '$complemento', '$telefone', '$produtos', '$preco_total')";

        if (mysqli_query($conn, $sql_pedido)) {
            $mensagem = "Pedido realizado com sucesso!";
            unset($_SESSION['cart']);
        } else {
            $mensagem = "Erro ao inserir pedido: " . mysqli_error($conn);
        }

        $sql_historico = "INSERT INTO historico (user_id, id_empresa, user_nome, user_endereco, user_n, user_complemento, telefone, produtos, preco_total) 
                      VALUES ('$id', '$empresa', '$nome', '$endereco', '$n', '$complemento', '$telefone', '$produtos', '$preco_total')";

        if (mysqli_query($conn, $sql_historico)) {
            $mensagem = "Pedido realizado com sucesso!";
            unset($_SESSION['cart']);
        } else {
            $mensagem = "Erro ao inserir pedido: " . mysqli_error($conn);
        }
    } else {
        $mensagem = "Seu carrinho está vazio.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="../../acetts/css/stylecarrinho.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <script>
        function Alert() {
            alert("Pedido feito com sucesso");
        }
    </script>
</head>
<body>
<nav>
    <?php
    // Consulta para obter informações da empresa
    $sql_empresa = "SELECT * FROM empresas WHERE id = '$empresa'";
    $dados_empresa = mysqli_query($conn, $sql_empresa);
    
    if ($dados_empresa && mysqli_num_rows($dados_empresa) > 0) {
        $linha_empresa = mysqli_fetch_assoc($dados_empresa);
        $foto = !empty($linha_empresa['foto']) ? $linha_empresa['foto'] : 'img/semfoto.jfif';
        $telefone = $linha_empresa['telefone'];
        $nome_empresa = $linha_empresa['nome'];
    } else {
        $foto = ''; 
        $nome_empresa = 'Empresa não encontrada';
    }
    ?>
    <div>
        <img src="../PainelEmpresa/<?php echo $foto; ?>" style="border-radius: 10%;" class="nav-logo">
        <p><?php echo $nome_empresa; ?><br><?php echo $telefone; ?></p>
    </div>
    <form action='homeprodutos.php' method='post'>
        <button type='submit' name='empresa' value='<?php echo $empresa; ?>' style="background: none; border: none; padding: 0; cursor: pointer; font-size: 24px;">
            <i class="fa-solid fa-arrow-left fa-lg" style="color: #ffffff;margin-right: 15px;"></i>
        </button>
    </form>
</nav>
<aside class="container normal-section">
    <h2 class="section-title">Carrinho</h2>
    <form method="POST" action="carrinho.php">
        <input type="hidden" name="empresa" value="<?php echo $empresa; ?>">
        <table class="table table-hover mx-auto">
            <thead>
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Preço</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $foto = !empty($item['foto']) ? $item['foto'] : '../PainelEmpresa/img/semfoto.jfif';
                    $preco = isset($item['preco']) ? number_format($item['preco'], 2, ',', '.') : '0,00';
                    $quantidade = intval($item['quantidade']);

                    if ($quantidade > 0) {
                        ?>
                        <tr>
                            <td><img src='<?php echo $foto; ?>' width='50px' height='50px'></td>
                            <td>R$ <?php echo $preco; ?></td>
                            <td>
                                <input type='number' id='quantidade_<?php echo $item['id']; ?>' class='item-quantity form-control' data-price='<?php echo $item['preco']; ?>' name='quantidade[<?php echo $item['id']; ?>]' value='<?php echo $quantidade; ?>' min='1' onchange='updateTotalPrice()'>
                            </td>
                            <td>
                                <button type='button' class='btn btn-primary' onclick='atualizarQuantidade(<?php echo $item['id']; ?>)'>Atualizar</button>
                                <button type='button' class='btn btn-danger' onclick='removeItem(<?php echo $item['id']; ?>)'>Remover</button>
                            </td>
                        </tr>
                        <?php
                    } else {
                        unset($_SESSION['cart'][$item['id']]);
                    }
                }
            } else {
                ?>
                <tr>
                    <td colspan="4">Nenhum item no carrinho.</td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <p id="total-price"><?php echo isset($preco_total) ? 'Total: R$ ' . number_format($preco_total, 2, ',', '.') : 'Total: R$ 0,00'; ?></p>
        <button type="submit" name="place_order" class="btn btn-primary" onclick="Alert()">Comprar</button>
    </form>
    <div id="mensagem" class="alert"><?php echo $mensagem; ?></div>
</aside>
<script>
    function updateTotalPrice() {
        let total = 0;
        const quantities = document.querySelectorAll('.item-quantity');
        quantities.forEach(quantity => {
            const price = parseFloat(quantity.dataset.price);
            const qty = parseInt(quantity.value);
            total += price * qty;
        });
        document.getElementById('total-price').innerText = 'Total: R$ ' + total.toFixed(2).replace('.', ',');
    }

    updateTotalPrice();

    function atualizarQuantidade(itemId) {
        const quantidadeInput = document.getElementById('quantidade_' + itemId);
        const novaQuantidade = parseInt(quantidadeInput.value);
    }

    function removeItem(itemId) {
        fetch(`scriptexcluir.php?id=${itemId}`, {
            method: 'GET'
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Erro ao tentar remover o item do carrinho.');
        })
        .then(data => {
            location.reload();
        })
        .catch(error => console.error('Erro ao remover item:', error));
    }
</script>
</body>
</html>
