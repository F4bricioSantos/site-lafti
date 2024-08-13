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
$id = $_SESSION['user_id'];

$sql = "SELECT * FROM empresas WHERE id = $id";
$dados = mysqli_query($conn, $sql);
$linha = mysqli_fetch_assoc($dados);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    date_default_timezone_set('America/Sao_Paulo');
    $data_pagamento = date('Y-m-d H:i:s'); 
    $tipo = $_POST['tipo_pagamento'];

    $sql = "UPDATE `empresas` SET `data_pagamento`='$data_pagamento', `tipo_pagamento`='$tipo' where id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script> window.location.href = 'perfil.php';</script>";
    } else {
        echo "<script>window.location.href = 'perfil.php';</script>";
    }

    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Perfil</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../acetts/css/stylePerfil.css">
</head>
<body style="margin-top: 10px;">
<div class="container">
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile">
                            <div class="user-avatar">
                                <img src="<?php echo !empty($linha['foto']) ? $linha['foto'] : 'img/semfoto.jfif'; ?>" alt="<?php echo $linha['nome']; ?>">
                            </div>
                            <h5 class="user-name"><?php echo $linha['nome']; ?></h5>
                            <h6><a href="uploadFoto.php">Atualizar foto</a></h6>

                            <form action="perfil.php" method="POST">
                                <label for="tipo_pagamento" style="margin-top: 20px;">Ultimo pagamento:<br> <?php echo $linha['data_pagamento']; ?> <br><?php echo $linha['tipo_pagamento']; ?></label>
                                <select name="tipo_pagamento" class="input2" required>
                                    <option value="mensal">Mensal R$150</option>
                                    <option value="anual">Anual R$1600</option>
                                </select>

                                <input class="button-cad btn btn-primary" type="submit" value="Renovar">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <form action="scriptUpdatePerfil.php" method="POST" class="card-body">
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h6 class="mb-2 text-primary">Perfil</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="fullName">Nome</label>
                                <input type="text" class="form-control" id="fullName" name="nome" value="<?php echo $linha['nome']; ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="eMail">Email</label>
                                <input type="email" class="form-control" id="eMail" name="email" value="<?php echo $linha['email']; ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="phone">Numero</label>
                                <input type="text" class="form-control" id="phone" name="telefone" value="<?php echo $linha['telefone']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h6 class="mt-3 mb-2 text-primary">INFORMAÇÕES</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="Street">Endereço</label>
                                <input type="text" class="form-control" id="Street" name="endereco" value="<?php echo $linha['endereco']; ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="ciTy">CNPJ</label>
                                <input type="text" class="form-control" id="ciTy" name="cnpj" value="<?php echo $linha['cnpj']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h6 class="mt-3 mb-2 text-primary">Funcionamento</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="Street">Horário de abertura</label>
                                <input type="time" class="form-control" id="Street" name="aberto" value="<?php echo $linha['aberto']; ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="ciTy">Horário de fechamento</label>
                                <input type="time" class="form-control" id="ciTy" name="fechado" value="<?php echo $linha['fechado']; ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="ciTy">Dias da semana separados por vírgula</label>
                                <input type="text" class="form-control" id="ciTy" placeholder="segunda, terça" name="dias" value="<?php echo $linha['dias']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="text-right">
                                <button class="btn btn-secondary"><a href="Pdutos.php" style="color: #fff;text-decoration: none;">Voltar</a></button>
                                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Atualizar">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript"></script>
</body>
</html>
