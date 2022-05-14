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
                if(!preg_match( '/^\d{4}-\d{2}-\d{2}$/' , $expr_date)){
                    $error["expr_date"] = true;
                }

                $product_img = new Upload("product_img", "images/{$_SESSION['user']['mid']}") ;
                $filename = $product_img->file() ?? "product.jpg" ;

                if (!isset($error)){
                    $stmt = $db->prepare("insert into product (mid, title, stock, normal_price, discnt_price, expr_date, img) values (?, ?, ?, ?, ?, ?, ?)") ;
                    $stmt->execute([$_SESSION["user"]["mid"], $title, $stock, $normal_price, $discnt_price, $expr_date, $filename]) ;
                    header("Location: product.php");
                    exit;
                }
                    
            }
        }
           
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 40px auto; 
        }
        td, tr{
            border: 1px solid gray;
            padding: 5px;
        }
    </style>
</head>
<body>
    <form action="" method="post"  enctype="multipart/form-data">
        <table>
            <tr>
                <td>TITLE</td>
                <td>STOCK</td>
                <td>NORMAL PRICE</td>
                <td>DISCOUNT PRICE</td>
                <td>EXPIRE DATE</td>
                <td>IMAGE</td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="title" value='<?= isset($title) ? $title : ""?>'>
                </td>
                <td>
                    <input type="text" name="stock" value='<?= isset($stock) ? $stock : ""?>'>
                </td>
                <td>
                    <input type="text" name="normal_price" value='<?= isset($normal_price) ? $normal_price : "" ?>'>
                </td>
                <td>
                    <input type="text" name="discnt_price" value='<?= isset($discnt_price) ? $discnt_price : "" ?>'>
                </td>
                <td>
                    <input type="date" name="expr_date" value='<?= isset($expr_date) ? $expr_date : "" ?>'>
                </td>
                <td><input type="file" name = "product_img"></td>
                <td>
                    <button type="submit">INSERT</button>
                </td>
            </tr>
        </table>
        
        <?php if(isset($error)){var_dump($error);}?>
    </form>
</body>
</html>