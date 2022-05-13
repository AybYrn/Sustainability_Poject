<?php
    session_start();
    require 'auth.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $_SESSION['user_type'] = authenticateUser($email, $password, $_SESSION['user']);
        if ($_SESSION['user_type'] !== false) {
            $_SESSION['email']=$email; //to be able to get user information
            header("Location: index.php");
        } else {
            header("Location: login.php?error=1");
        }
        exit;
    }
    else {
        if (isset($_GET['error'])){
            $error = filter_var($_GET['error'], FILTER_VALIDATE_INT);
            if (!$error) {
                gotoError(405);
            }
            else {
                $errors = [
                    1 => 'Incorrect email or password'
                ];
                $error = $errors[$error];
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
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
            text-align: center;
        }
        div#main {
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <form action="" method="post">
        <input type="text" name="email" placeholder="E-mail">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Submit</button>
    </form>
</body>
</html>