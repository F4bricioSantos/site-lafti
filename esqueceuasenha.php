<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleLog.css">
    <link rel="shortcut icon" type="imagex/png" href="icons/img-01.png">
    <title>LAFTI</title>
</head>
<body>
    <div class="content-principal">

        <div class="content-quadrado">           
        
            <div class="content-login">
                <h4> Recuperar Senha</h4>
                    <?php
                    include "conexao.php";             

                    ?>
                <form action="testelogin.php" method="POST">
                    <label> Email </label>
                    <input type="email" name="email" placeholder=" Digite Email" class=" input">       
                    <input type="submit" value="Recuperar" name="ok"   class="button-entrar">
                </form>
            </div>
        </div>
    </div> 
    <script src="script.js"></script>
</body>
</html>