<?php
session_start();
require '../auth.php';
function getProduct($pid){
    global $db;
    $sql = "SELECT * FROM product WHERE pid = ?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$pid]);
    return $stmt->fetch();
}
if (!validSession()){
    header('location: login.php');
    exit;
}
$cart = $_SESSION['cart'];
$totalQuantity = 0;
$totalPrice = 0;
$cart[] = ["pid" => 1, "cnt" => 2];
foreach ($cart as $item){
    $totalQuantity += $item['cnt'];
    $totalPrice += $item['cnt'] * getProduct($item['pid'])['discnt_price'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../index.css">
    <style>
        * {
            font-family: Abel;
        }
        div.btn:hover {
            cursor: pointer;
        }
    </style>
    <title>Cart</title>
</head>
<body>
    <table id="cart">
        
            <tr>
                <td></td>
                <td>Title</td>
                <td>Normal Price</td>
                <td>Discount Price</td>
                <td>Expire Date</td>
                <td>Quantity</td>
            </tr>
            <script>
                function updateCart(pid, cnt){
                    let link = "../add.php?pid=" + pid;
                    if (cnt < 0)
                        link += "&m=1";
                    cnt = Math.abs(cnt);
                    for (let i = 0; i < cnt; i++) {
                        $.get(link, function(data){
                            return true;
                        });
                    }
                }
            </script>
            <?php foreach ($cart as $item) {
                $product = getProduct($item['pid']);
            ?>
            <tr class="item">
                <td><img src='../images/<?php if ($product["img"] !== "product.jpeg") echo $product["mid"], "/"; ?><?=$product["img"]?>'></td>
                <td><?= $product['title'] ?></td>
                <td><?= $product['normal_price'] ?></td>
                <td><?= $product['discnt_price'] ?></td>
                <td><?= $product['expr_date'] ?></td>
                <td class="quantity">
                    <div class="btn" onclick="updateCart(<?= $product['pid'] ?>, 1)"><i class="fa-solid fa-plus"></i></div>
                    <div><?= $item['cnt'] ?></div>
                    <div class="btn" onclick="updateCart(<?= $product['pid'] ?>, -1)"><i class="fa-solid fa-minus"></i></div>
                </td>
            <?php } ?>

            <tr>
                <td colspan="5">Total Number Of Items</td>
                <td><?= $totalQuantity ?></td>
            </tr>
            <tr>
                <td colspan="5">Total Price</td>
                <td><?= $totalPrice ?></td>
            </tr>
    </table>    
</body>
</html>