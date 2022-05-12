<?php
	session_start();
	//$conn = new mysqli('localhost', 'root', '', 'test');
	//$sql = "SELECT * FROM product WHERE pid IN (".implode(',',$_SESSION['cart']).")";
	//$query = $conn->query($sql);
	$message ="| ";
	if(isset($_POST['save'])){
		foreach($_POST['indexes'] as $key){
			if( $_POST['stock_'.$key] >=  $_POST['qty_'.$key]){
				$_SESSION['qty_array'][$key] = $_POST['qty_'.$key];
				$message = $message.'Cart updated for: '.$_POST['title_'.$key]." |\n";
				
			}
			else if($_POST['stock_'.$key] <  $_POST['qty_'.$key]){
				$message =	$message.'There is no available stock (max '.$_POST['stock_'.$key].') for: '.$_POST['title_'.$key]." |\n";
			
			}
			
		}
		
		$_SESSION['message'] = $message;
		header('location: view_cart.php');
	}
	
		
	
	
?>