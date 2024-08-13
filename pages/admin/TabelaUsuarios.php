<?php
include "../../conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        if (isset($_POST['Bloquear_x'])) {
            $sql = "UPDATE `users` SET `estado`='bloqueado' WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                // Success
            } else {
                // Error
            }
        } elseif (isset($_POST['Desbloquear_x'])) {
            $sql = "UPDATE `users` SET `estado`='desbloqueado' WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                // Success
            } else {
                // Error
            }
        } elseif (isset($_POST['Excluir'])) {
            echo "Usuário com ID $id excluído.";
        } else {
            echo "Nenhuma ação válida foi selecionada.";
        }
    } else {
      // echo "Nenhum ID foi fornecido.";
    }
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
</head>

<body>
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
<?php
include "navbarLateral.php";
$pesquisa = $_POST['busca'] ?? '';
$sql = "SELECT * FROM users WHERE nome LIKE '%$pesquisa%' OR id LIKE '%$pesquisa%'";
$dados = mysqli_query($conn, $sql);
?>

<div class="container" style="margin-left: 0px;">
    <nav class="navbar bg-body">
        <div class="container">
            <form class="d-flex" role="search" action="TabelaUsuarios.php" method="POST">
                <input class="form-control me-2" type="search" placeholder="Nome ou id" aria-label="Search" name="busca" style="height: 40px; width: 250px;">
                <button class="btn btn-outline-success" type="submit">Pesquisar</button>
            </form> 
        </div>
    </nav>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Data de Nascimento</th>
                <th scope="col">Endereço</th>
                <th scope="col">N</th>
                <th scope="col">Telefone</th>
                <th scope="col">Email</th>
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
                $nome = $linha['nome'];
                $data_nascimento = '01/12/2000'; // Atualizar conforme a estrutura do seu banco de dados
                $endereco = $linha['endereco'];
                $n = $linha['n'];
                $telefone = $linha['telefone'];
                $email = $linha['email'];
                $estado = $linha['estado'];

                echo "<tr>
                    <td>$id</td>
                    <td>$nome</td>
                    <td>$data_nascimento</td>
                    <td>$endereco</td>
                    <td>$n</td>
                    <td>$telefone</td>
                    <td>$email</td>
                    <td>$estado</td>
                    <td style='width: 163px;'>
                        <form action='TabelaUsuarios.php' method='POST' style='display: inline-block;'>
                            <input type='hidden' name='id' value='$id'>
                            <input type='image' src='../../icons/bloquear.png' width='45px' name='Bloquear' alt='Bloquear' class='btn btn-warning'>
                        </form>
                        <form action='TabelaUsuarios.php' method='POST' style='display: inline-block;'>
                            <input type='hidden' name='id' value='$id'>
                            <input type='image' src='../../icons/desbloquear.png' width='45px' name='Desbloquear' alt='Desbloquear' class='btn btn-warning'>
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
                <form action="scriptExcluirUser.php" method="POST">
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
