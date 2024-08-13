<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="acetts/css/styleLog.css">
    <link rel="shortcut icon" type="imagex/png" href="icons/img-01.png">
    <title>LAFTI</title>
</head>
<body>
    <div class="content-principal">
        <div class="content-quadrado">            
            <div class="content-login">
                <img src="icons/img-01.png" class="logo-login">
                <p class="login">LOGIN</p>
                <h4>
                    <?php 
                    error_reporting(0);
                    session_start();
                    session_destroy();
                    echo $_SESSION['LoginMensagem'];
                    ?>
                </h4>
                <form action="testelogin.php" method="POST" style="display:flex;flex-direction:column; align-items: center;">
                    <input type="email" name="email" placeholder="Email" class=" input" >
                    <input type="password" name="senha" placeholder="Senha" class="input " >
                
                <div class="links-">
                    <a href="esqueceusenha.php">Esqueceu senha?</a>
                    <a href="pages/PainelUsuario/caduser.php" >Criar conta</a>
                    <a href="pages/PainelEmpresa/cademp.php" >Criar conta empresa</a>
                </div>
                    <input type="submit" name="submit" value="Entrar"  class="button-entrar" style="margin-bottom: 5px;">
                </form>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>