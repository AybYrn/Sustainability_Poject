<?php
	session_start();
    require '../auth.php';
    $user = getUser($_SESSION['user']['email']);
    if (!$user){
        gotoError(405);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
			if(isset($_SESSION['message'])){
				?>
				<div class="alert alert-info text-center">
					<?php echo $_SESSION['message']; ?>
				</div>
				<?php
				unset($_SESSION['message']);
			}
 
			?>
    <form method="post" action="save_profile.php">
    <table>
        <th colspan="2"><td>Hello <?= $user["name"]?></td></th>
        <tr><td><p>Email: <?= $user["email"] ?></p></td></tr>
        <tr><td><p>Name: </p> <input type="text" value="<?= $user["name"] ?>" name="name"></td></tr>
        <tr><td><p>City: </p> <input type="text" value="<?= $user["city"] ?> " name="city"> <p>District:</p> <input type="text" value="<?= $user["district"] ?>" name="district"></td></tr>
        <tr><td><p>Address: </p> <input type="text" value="<?= $user["address"] ?>" name="address"></td></tr>
        <tr>
            <td><p>Password: </p><input type="password" name="password_new"> <p>Re Enter Password: </p><input type="password" name="password_new2"></td>
        </tr>
        <?php 
        if(!empty($user["mid"])){ ?>
            <tr><td><p>Your Market Id is: <?= $user["mid"] ?></p></td></tr>
        <?php } ?>
        <tr><td><button <?= $_SESSION["message"]="" ?> type="submit" class="btn btn-success" name="save">Save Changes</button></td>
    <td><a <?= $_SESSION["message"]="No edit made" ?> href="profile.php">Cancel</a></td></tr>
    </table>
    </form>
</body>
</html>