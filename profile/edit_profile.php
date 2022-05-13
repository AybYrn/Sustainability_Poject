<?php
	session_start();
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
<?php
	$conn = new mysqli('localhost', 'root', '', 'test');
    $keyword = $_SESSION['email'];
    // if($_SESSION['user_type']="market")
   $sql = "SELECT * FROM market WHERE email LIKE '%" . $keyword . "%'";
   // else if($_SESSION['user_type']="consumer")
    //$sql= "SELECT * FROM consumer WHERE email LIKE '%" . $keyword . "%'";
	$query = $conn->query($sql);
    //var_dump($query);
	while($row = $query->fetch_assoc()){
        ?>
    <form method="POST" action="save_profile.php">
    <table>
        <th colspan="2"><td>Hello <?= $row["name"]?></td></th>
        <tr><td><p>Email: <?= $row["email"] ?></p></td></tr>
        <tr><td><p>Name: </p> <input type="text" value="<?= $row["name"] ?>" name="name"></td></tr>
        <tr><td><p>City: </p> <input type="text" value="<?= $row["city"] ?> " name="city"> <p>District:</p> <input type="text" value="<?= $row["district"] ?>" name="district"></td></tr>
        <tr><td><p>Address: </p> <input type="text" value="<?= $row["address"] ?>" name="address"></td></tr>
        <tr>
            <td><p>Password: </p><input type="password" name="password_new"> <p>Re Enter Password: </p><input type="password" name="password_new2"></td>
        </tr>
        <?php 
        if(!empty($row["mid"])){ ?>
            <tr><td><p>Your Market Id is: <?= $row["mid"] ?></p></td></tr>
        <?php } ?>
        <tr><td><button <?= $_SESSION["message"]="" ?> type="submit" class="btn btn-success" name="save">Save Changes</button></td>
    <td><a <?= $_SESSION["message"]="No edit made" ?> href="profile.php">Cancel</a></td></tr>
    </table>
    </form>

        <?php } ?>
</body>
</html>