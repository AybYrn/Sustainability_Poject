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
	while($row = $query->fetch_assoc()){
        ?>
    <table>
        <th colspan="2"><td>Hello <?= $row["name"]?></td></th>
        <tr><td><p>Email: <?= $row["email"] ?></p></td></tr>
        <tr><td><p>Name: <?= $row["name"] ?></p></td></tr>
        <tr><td><p>City: <?= $row["city"] ?> District: <?= $row["district"] ?></p></td></tr>
        <tr><td><p>Address: <?= $row["address"] ?></p></td></tr>
        <?php 
        if(!empty($row["mid"])){ ?>
            <tr><td><p>Your Market Id is: <?= $row["mid"] ?></p></td></tr>
        <?php } ?>
        <tr><td><a href="edit_profile.php">Edit Profile</a></td></tr>
    </table>
        <?php } ?>
</body>
</html>