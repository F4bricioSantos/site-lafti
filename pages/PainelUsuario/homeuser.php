<?php
include "../../conexao.php";
session_start();

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] !== 'user') {
    header("location: ../../index.php");
    exit;
}

$id = $_SESSION['user_id'];
$pesquisa = $_POST['busca'] ?? '';


date_default_timezone_set('America/Sao_Paulo');

$itens_por_pagina = 15;
$pagina = $_GET['pagina'] ?? 1;
$offset = ($pagina - 1) * $itens_por_pagina;

$sql_total = "SELECT COUNT(*) as total FROM empresas WHERE nome LIKE '%$pesquisa%'";
$resultado_total = mysqli_query($conn, $sql_total);
$linha_total = mysqli_fetch_assoc($resultado_total);
$total_itens = $linha_total['total'];
$total_paginas = ceil($total_itens / $itens_por_pagina);

$sql = "SELECT * FROM empresas WHERE nome LIKE '%$pesquisa%' LIMIT $offset, $itens_por_pagina";
$dados = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../acetts/css/styleHome.css">
    <title>LAFTI</title>
    <style>
        .card button {
            height: 30px;
            width: 100px;
            color: #ffffff;
            margin-top: auto;
            border: none;
        }
        .fechado {
            color: red;
            display: flex;
            justify-content: center;
        }
        .aberto {
            color: green;
            display: flex;
            justify-content: center;
        }
        .botao-aberto {
            background-color: #68008B;
            color: white;
        }
        .botao-fechado {
            background-color: #a9a9a9;
            color: #606060;
            cursor: not-allowed;
            color: white;
        }
    </style>
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
<section class="content">
    
    <?php
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $dataAtual = new DateTime();
    $diaSemanaAtual = strtolower($dataAtual->format('l'));
    $horaAtual = $dataAtual->format('H:i:s');

    $diasEmPortugues = [
        'sunday' => 'domingo',
        'monday' => 'segunda',
        'tuesday' => 'terça',
        'wednesday' => 'quarta',
        'thursday' => 'quinta',
        'friday' => 'sexta',
        'saturday' => 'sabado'
    ];

    $diaAtualEmPortugues = $diasEmPortugues[$diaSemanaAtual] ?? '';

    while ($linha = mysqli_fetch_assoc($dados)) {
        $foto = !empty($linha['foto']) ? $linha['foto'] : 'img/semfoto.jfif';
        $nome = $linha['nome'];
        $id_empresa = $linha['id'];
        $estado = $linha['estado'];

        $sql = "SELECT aberto, fechado, dias FROM empresas WHERE id = $id_empresa";
        $result = $conn->query($sql);

        if($estado == 'desbloqueado'){
        

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $horaAbertura = $row['aberto'];
            $horaFechamento = $row['fechado'];
            $diasSemana = array_map('trim', explode(',', $row['dias']));

            $diaAtivo = in_array($diaAtualEmPortugues, $diasSemana);
            $botaoAtivo = $diaAtivo && ($horaAtual >= $horaAbertura && $horaAtual <= $horaFechamento);
            $classeBotao = $botaoAtivo ? 'botao-aberto' : 'botao-fechado';

            echo "<div class='card'>
                <img src='../PainelEmpresa/$foto' >
                <p><b>$nome</b></p>
                <form action='homeprodutos.php' method='post'>
                <input type='hidden' name='empresa' value='$id_empresa'>
                    <div id='status'>
                    <button type='submit' id='botao' class='$classeBotao' " . (!$botaoAtivo ? 'disabled' : '') . ">ver mais</button>
                    <div id='mensagem' class='" . ($botaoAtivo ? 'aberto' : 'fechado') . "'>
                    " . ($botaoAtivo ? 'Aberto' : 'Fechado') . "
                    </div>
                    </div>
                </form>
              </div>";
        } else {
            echo "Configurações não encontradas para a empresa com ID $id_empresa.";
        }
    }}
    $conn->close();
    ?>
</section>
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
<?php include "../footer.php";?>
</body>
</html>
