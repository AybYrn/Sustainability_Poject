<?php
	session_start();
	//$conn = new mysqli('localhost', 'root', '', 'test');
	//$sql = "SELECT * FROM product WHERE pid IN (".implode(',',$_SESSION['cart']).")";
	//$query = $conn->query($sql);
    if(isset($_POST['save'])){
if($_POST['password_new'] != $_POST['password_new2'] ||  $_POST['password_new2']==""){
    $_SESSION['message'] = "Problem occured, recheck the passwords!!";
header('location: edit_profile.php');
}
else if($_POST['district']==""){
    $_SESSION['message'] = "Problem occured, recheck the district!!";
    header('location: edit_profile.php');
}
else if( $city=$_POST['city']==""){
    $_SESSION['message'] = "Problem occured, recheck the city!!";
    header('location: edit_profile.php');
}
else if($_POST['name']==""){
    $_SESSION['message'] = "Problem occured, recheck the name!!";
    header('location: edit_profile.php');
}
else if($_POST['address']==""){
    $_SESSION['message'] = "Problem occured, recheck the address!!";
    header('location: edit_profile.php');
}
else{
    $address=$_POST['address'];
    $password_new=$_POST['password_new'];
    $name=$_POST['name'];
    $city=$_POST['city'];
    $district=$_POST['district'];

    $conn = new mysqli('localhost', 'root', '', 'test');
    $keyword = $_SESSION['email'];
    // if($_SESSION['user_type']="market")
   $sql = "UPDATE market SET name='".$name."',password='".$password_new."',address='".$address."',city='".$city."',district='".$district."' WHERE email LIKE '%" . $keyword . "%'";
   // else if($_SESSION['user_type']="consumer")
   // $sql = "UPDATE consumer SET name='".$name."',password='".$password_new."',address='".$address."',city='".$city."',district='".$district."' WHERE email LIKE '%" . $keyword . "%'";
	$query = $conn->query($sql);
    $_SESSION['message'] = "succesfully edited";
		header('location: profile.php');
}

} 
?>