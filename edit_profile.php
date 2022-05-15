<?php
	session_start();
    require 'auth.php';
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Abel&display=swap">
    <title>Edit</title>
    <style>
        * {
            font-family: Abel;
            background-color: #f5f5f5;
        }
        table{
            font-size: 20px;
            margin: 20px auto;
            width: 700px;
            height: 800px;
            background: rgb(255, 255, 255);
            border-radius: 0.4em;
            box-shadow: 0.3em 0.3em 0.7em #00000015;
            transition: border 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: rgb(250, 250, 250) 0.2em solid;

        }
        table:hover {
            border: #006fff 0.2em solid;
        }
        a{
            text-decoration: none;
            margin-top: 10px;
            font-weight: bold;
        }
        p{
            margin-left: 10px;
        }
       
        input {
        font-weight: bold;
        line-height: 28px;
        border: 2px solid transparent;
        border-bottom-color: #777;
        padding: .2rem 0;
        outline: none;
        background-color: transparent;
        color: #0d0c22;
        transition: .3s cubic-bezier(0.645, 0.045, 0.355, 1);
        padding-left:15px ;
        }

        input:focus, input:hover {
        outline: none;
        padding: .2rem 1rem;
        border-radius: 1rem;
        border-color: #7a9cc6;
        }

        input::placeholder {
        color: #777;
        }

        input:focus::placeholder {
        opacity: 0;
        transition: opacity .3s;
        }
        
        button {
        --primary-color: #645bff;
        --secondary-color: #fff;
        --hover-color: #111;
        --arrow-width: 10px;
        --arrow-stroke: 2px;
        box-sizing: border-box;
        border: 0;
        border-radius: 20px;
        color: var(--secondary-color);
        padding: 1em 1.8em;
        background: var(--primary-color);
        display: flex;
        transition: 0.2s background;
        align-items: center;
        gap: 0.6em;
        font-weight: bold;
        margin-top: 5px;
        }

        button .arrow-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: 10px;

        }

        button .arrow {
        margin-top: 1px;
        background: var(--primary-color);
        height: var(--arrow-stroke);
        position: relative;
        transition: 0.2s;
        }

        button .arrow::before {
        content: "";
        box-sizing: border-box;
        position: absolute;
        border: solid var(--secondary-color);
        border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
        display: inline-block;
        top: -3px;
        right: 3px;
        transition: 0.2s;
        padding: 3px;
        transform: rotate(-45deg);
        }

        button:hover {
        background-color: var(--hover-color);
        }

        button:hover .arrow {
        background: var(--secondary-color);
        }

        button:hover .arrow:before {
        right: 0;
        }
    </style>
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
        <tr><td><p> <b>Email:</b> <?= $user["email"] ?></p></td></tr>
        <tr><td><p> <b>Name:</b> <input type="text" value="<?= $user["name"] ?>" name="name"> </p></td></tr>
        <tr><td><p> <b>City:</b> <input type="text" value="<?= $user["city"] ?> " name="city"></p>  <p> <b>District: </b><input type="text" value="<?= $user["district"] ?>" name="district"></p> </td></tr>
        <tr><td><p> <b>Address:</b>  <input type="text" value="<?= $user["address"] ?>" name="address"></p></td></tr>
        <tr>
            <td><p> <b>Password:</b> <input type="password" name="password_new"></p> <p> <b>Re-enter Password:</b><input type="password" name="password_new2"> </p></td>
        </tr>
        <?php 
        if(!empty($user["mid"])){ ?>
            <tr><td><p> <b>Your Market Id is:</b> <?= $user["mid"] ?></p></td></tr>
        <?php } ?>
        <tr><td><button <?= $_SESSION["message"]="" ?> type="submit" class="btn btn-success" name="save">Save Changes
        <div class="arrow-wrapper">
                <div class="arrow"></div>
            </div>
        </button></td>
        <tr><td><a <?= $_SESSION["message"]="No edit made" ?> href="profile.php">Cancel</a></td></tr>
    </table>
    </form>
</body>
</html>