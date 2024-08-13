<?php 
include "../../conexao.php";

session_start();

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] == 'empresa' || $_SESSION['usertype'] == 'admin') {
    header("location: ../../index.php");
    exit;
}
$id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = $id";
$dados = mysqli_query($conn, $sql);
$linha = mysqli_fetch_assoc($dados);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>perfil</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../acetts/css/StylePerfil.css">
</head>
<style>
    .row.gutters{
        justify-content: center;
    }
</style>
<body>
<div class="container">
    <div class="row gutters">
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
                            <div class="form-group">
                                <label for="phone">telefone</label>
                                <input type="text" class="form-control" id="phone" name="telefone" value="<?php echo $linha['telefone']; ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="eMail">Email</label>
                                <input type="email" class="form-control" id="eMail" name="email" value="<?php echo $linha['email']; ?>">
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
                            <div class="form-group">
                                <label for="Street">Complemento</label>
                                <input type="text" class="form-control" id="Street" name="complemento" value="<?php echo $linha['complemento']; ?>">
                            </div>
                            
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="ciTy">N°</label>
                                <input type="text" class="form-control" id="ciTy" name="n" value="<?php echo $linha['n']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="text-right">
                                <button class="btn btn-secondary"><a href="homeuser.php" style="color: #fff;text-decoration: none;">Voltar</a></button>
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
