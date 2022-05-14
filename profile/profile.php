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
    <title>Profile</title>
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
    <table>
        <th colspan="2"><td>Hello <?= $user["name"]?></td></th>
        <tr><td><p>Email: <?= $user["email"] ?></p></td></tr>
        <tr><td><p>Name: <?= $user["name"] ?></p></td></tr>
        <tr><td><p>City: <?= $user["city"] ?> District: <?= $user["district"] ?></p></td></tr>
        <tr><td><p>Address: <?= $user["address"] ?></p></td></tr>
        <?php 
        if(isset($user['mid'])){ ?>
            <tr><td><p>Your Market Id is: <?= $user['mid'] ?></p></td></tr>
        <?php } ?>
        <tr><td><a href="edit_profile.php">Edit Profile</a></td></tr>
    </table>
</body>
</html>