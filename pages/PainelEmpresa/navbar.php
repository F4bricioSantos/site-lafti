<?php
include "../../conexao.php";

if (!isset($_SESSION['email'])) {
    header("location: ../../index.php");
    exit;
}

if ($_SESSION['usertype'] == 'user' || $_SESSION['usertype'] == 'admin') {
    header("location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: transparent; 
        }

        .navbar-toggler {
            background-color: transparent;
            color: #f3f3f3;
            border: none; 
            display: flex;
            width: 60px;
            height: 60px;
            justify-content: center;
            align-items: center;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30' width='40' height='40'%3E%3Cpath stroke='rgba(255, 255, 255, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
            background-position: center;
            background-repeat: no-repeat;
            width: 40px; 
            height: 40px; 
        }
        .offcanvas-collapse {
            position: fixed;
            top: 0;
            bottom: 0;
            right: -250px;
            width: 250px;
            padding: 1rem;
            overflow-y: auto;
            background-color: rgba(248, 249, 250, 0.8); 
            transition: right 0.3s ease-in-out;
            z-index: 1045;
        }
        .offcanvas-collapse.open {
            right: 0;
        }
        .close-btn {
            position: absolute;
            top: 3px;
            left: 15px;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .navbar-nav .nav-link {
            font-size: 1.25rem;
            margin-top: 10px;
            color: #333; 
        }
    </style>
    <title>LAFTI</title>
</head>
<body>
    <nav class="navbar navbar-light" style="width: 90px;">
        <button class="navbar-toggler" type="button" id="navbarSideCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="offcanvas-collapse" id="offcanvasMenu">
        <div class="close-btn" id="closeBtn">&times;</div>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="Pdutos.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pedidos.php">Pedidos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="HistoricoPedidos.php">Histórico</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="perfil.php">Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../logout.php">Sair</a>
            </li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#navbarSideCollapse').on('click', function () {
                $('#offcanvasMenu').toggleClass('open');
            });
            $('#closeBtn').on('click', function () {
                $('#offcanvasMenu').removeClass('open');
            });
        });
    </script>
</body>
</html>
