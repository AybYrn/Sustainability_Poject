<?php
    session_start();
    require '../auth.php';
    require_once './vendor/autoload.php' ;
    require_once './Mail.php' ;
    function generateConfirmationCode(){
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    if (validSession()) {
        header("Location: ../index.php");
        exit;
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        if (isset($_POST["email"]) && isset($_POST["password_confirmation"]) && isset($_POST["password"])) {
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            $password_confirmation = filter_var($_POST["password_confirmation"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userType = filter_var($_POST["userType"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $name = filter_var($_POST["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $city = filter_var($_POST["city"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $address = filter_var($_POST["address"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $district = filter_var($_POST["district"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!$email){
                $error["email_chars"] = "invalid characters used in email";
            }
            if (!$password){
                $error["password_chars"] = "invalid characters used in password";
            }
            // regex for email
            if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
                $error["email_format"] = "invalid email format";
            }
            if (strlen($password) < 5) {
                $error["password_len"] = "Password must be at least 4 characters long";
            }
            if ($password !== $password_confirmation){
                $error["password_match"] = "Passwords do not match";
            }
            if ($userType !== "market" && $userType !== "consumer") {
                $error["user_type"] = "user type is invalid";
            }
            if (!isset($error)){
                $_SESSION["register"]["confirmation_code"] = generateConfirmationCode();
                $_SESSION["register"]["email"] = $email;
                $_SESSION["register"]["password"] = password_hash($password, PASSWORD_BCRYPT);
                $_SESSION["register"]["user_type"] = $userType;
                $_SESSION["register"]["name"] = $name;
                $_SESSION["register"]["city"] = $city;
                $_SESSION["register"]["district"] = $district;
                $_SESSION["register"]["address"] = $address;

                try {
                    $message = "<p>Your confirmation code is: <b>" . $_SESSION["register"]["confirmation_code"] . "</b></p>";
                    $_SESSION["message"] = $message;
                    Mail::send($email, "SustainabilityMarket: Email Confirmation", $message);
                } catch (Exception $e) {
                    $_SESSION["register"]["error"] = "Error sending email";
                }
                header("Location: confirmation.php");
                exit;
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
    <title>Register</title>
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
        <h1>Register</h1>
    </header>
    <div id="main">
        <form action="" method="post">
            <select name="userType">
                <option value="market">Market</option>
                <option value="consumer" selected>Consumer</option>
            </select>
            <input type="text" name="email" placeholder="E-mail" <?= isset($email) ? "value='$email'" : "" ?>>
            <input type="password" name="password" placeholder="Password" <?= isset($password) ? "value='$password'" : "" ?>>
            <input type="password" name="password_confirmation" placeholder="Re-enter Password" <?= isset($password_confirmation) ? "value='$password_confirmation'" : "" ?>>
            <input type="text" name="name" placeholder="Name" <?= isset($name) ? "value='$name'" : "" ?>>
            <input type="text" name="city" placeholder="City" <?= isset($city) ? "value='$city'" : "" ?>>
            <input type="text" name="district" placeholder="District" <?= isset($district) ? "value='$district'" : "" ?>>
            <input type="text" name="address" placeholder="Address" <?= isset($address) ? "value='$address'" : "" ?>>
            <button type="submit">Submit</button>
        </form>
    </div>
    <?php
            if (isset($error)) {
                echo "<table>";
                foreach ($error as $key => $value) {
                    ?>
                    <tr><td><?= $key ?> =></td><td><?= $value ?></td></tr>
                    <?php
                }
                echo "</table>";
            }
        ?>
</body>
</html>