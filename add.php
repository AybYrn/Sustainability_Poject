<?php
    session_start();
    require "auth.php";
    $pid = filter_var($_GET["pid"], FILTER_VALIDATE_INT);
    $flag = false;
    $cart_size = count($_SESSION["cart"]);
    for ($i = 0; $i < $cart_size; $i++){
        if($_SESSION["cart"][$i]["pid"] === $pid){
            if (isset($_GET['m']))
            $_SESSION["cart"][$i]["cnt"]--;
            else
            $_SESSION["cart"][$i]["cnt"]++;
            if ($_SESSION["cart"][$i]["cnt"] === 0){
                unset($_SESSION["cart"][$i]);
            }
            $flag = true;
        }
    }
    if (!$flag) {
        $_SESSION['cart'][] = ["pid" => $pid,
                            "cnt" => 1];
    }
    
?>