<?php
session_start();
require 'auth.php';
if (validSession()) {
    // there are no restrictions on this page.
    // but the pages display will change if there is a 
    // consumer logged in.
    var_dump($_SESSION);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
</head>
<body>

</body>
</html>