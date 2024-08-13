<?php
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION['cart'][$key]); 
                break;
            }
        }

        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

header('Location: carrinho.php');
exit();

