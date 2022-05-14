<?php
    session_start();
    require_once "auth.php";
    require "Upload.php" ;

    if(validSession()){
        if($_SESSION["user_type"] === "market"){
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                extract($_POST);
                $title = filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if (!$title) $error["title"] = true;
                $stock = filter_var($stock, FILTER_VALIDATE_INT);
                if (!$stock) $error["stock"] = true;
                $normal_price = filter_var($normal_price, FILTER_VALIDATE_FLOAT);
                if (!$normal_price) $error["normal_price"] = true;
                $discnt_price = filter_var($discnt_price, FILTER_VALIDATE_FLOAT);
                if (!$discnt_price) $error["discnt_price"] = true;
                $pid = filter_var($_GET["edit"], FILTER_VALIDATE_INT);
                if (!$pid) $error["title"] = true;
                if(!preg_match( '/^\d{4}-\d{2}-\d{2}$/' , $expr_date)){
                    $error["expr_date"] = true;
                }
                
                $img = new Upload("img", "images/{$_SESSION['user']['mid']}") ;
                if($_FILES["img"]["size"] !== 0 ){
                    $filename = $img->file();
                    if (!isset($error)){
                        try {
                            $db->prepare("update product set title = ?, stock = ?, normal_price = ?, discnt_price = ?, expr_date = ?, img = ? where pid=?")->execute([$title, $stock, $normal_price, $discnt_price, $expr_date, $filename, $pid]) ;
                        } catch (PDOException $e) {
                            var_dump($e);
                        }
                        // header("Location: product.php");
                        // exit;
                    }
                }
                else{
                    if (!isset($error)){
                        $db->prepare("update product set title = ?, stock = ?, normal_price = ?, discnt_price = ?, expr_date = ? where pid=?")->execute([$title, $stock, $normal_price, $discnt_price, $expr_date, $pid]) ;
                        header("Location: product.php");
                        exit;
                    }
                }
            }
            if(isset($_GET["delete"])){
                $db->prepare("delete from product where pid=?")->execute([filter_var($_GET["delete"], FILTER_VALIDATE_INT)]) ;
            }
            $stmt = $db->prepare("select * from product where mid = ?") ;
            $stmt->execute([$_SESSION["user"]["mid"]]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{
            gotoError(401);
        }
    }else{
        header("Location: login.php");
        exit;
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css');

        body{
            font-family: Abel;
        }
        img {
            width: 150px;
            height: 150px;
        }
        table {
            border-collapse: collapse;
            margin: 40px auto; 
            width: 1250px;
            font-size: 30px;
        }
        tr:first-of-type{
            color: blue;
            font-weight: bold;
        }
        td, tr{
            border-bottom: 2px solid lightgray;
            text-align: center;
            padding: 5px;

        }
        h1{
            text-align: center;
        }
        a, button{
            width: 100px;
            color: lightsalmon;
        }
        a:visited {
            color: lightsalmon;
        }
    </style>
</head>
<body>
    <h1>PRODUCTS</h1>
    <table>
        <tr>
            <td>IMAGE</td>
            <td>TITLE</td>
            <td>STOCK</td>
            <td>NORMAL PRICE</td>
            <td>DISCOUNT PRICE</td>
            <td>EXPIRE DATE</td>
        </tr>
        <?php  foreach( $products as $product) : ?>
            <tr>
                <td> <img src='./images/<?php if ($product["img"] !== "product.jpeg") echo $product["mid"], "/"; ?><?=$product["img"]?>'></td>
                <td><?=$product["title"]?></td>
                <td><?=$product["stock"]?></td>
                <td><?=$product["normal_price"]?></td>
                <td><?=$product["discnt_price"]?></td>
                <td><?=$product["expr_date"]?></td>
                <td>
                    <a href='?edit=<?=$product["pid"]?>'><i class="fa-solid fa-pencil"></i></a>
                    <br>
                    <a href='?delete=<?=$product["pid"]?>'><i class="fa-solid fa-trash"></i></a>
                </td>
                </tr>
        <?php  endforeach ; 
            if (isset($_GET["edit"])) {
                $stmt = $db->prepare("select * from product where pid = ?") ;
                $stmt->execute([filter_var($_GET["edit"], FILTER_VALIDATE_INT)]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <div>
            <form action="" method="post"  enctype="multipart/form-data">
                <input type="text" name="title" value='<?= isset($title) ? $title : $product["title"]?>'>
                <input type="text" name="stock" value='<?= isset($stock) ? $stock : $product["stock"]?>'>
                <input type="text" name="normal_price" value='<?= isset($normal_price) ? $normal_price : $product["normal_price"]?>'>
                <input type="text" name="discnt_price" value='<?= isset($discnt_price) ? $discnt_price : $product["discnt_price"]?>'>
                <input type="date" name="expr_date" value='<?= isset($expr_date) ? $expr_date : $product["expr_date"]?>'>
                <input type="file" name="img">
                <button type="submit">EDIT</button>
                <?php if(isset($error)){var_dump($error);}?>
            </form>
        </div>

         <?php  }?>
         <tr>
             <td colspan="7">
                <a href="insert.php"><i class="fa-solid fa-square-plus"></i></a>
             </td>
         </tr>
    </table>
</body>
</html>