<?php
session_start();
error_reporting(0);
require 'functions/users.php';

	if(isset($_SESSION['un'])==false){
		if(isset($username)==true){
			$_SESSION['un']=$username;
		}else{
			header('Location: login.php');
		}
	}else{
		$username=$_SESSION['un'];
	}
	if(isset($_SESSION['pw'])==false){
		$_SESSION['pw']=$password;
	}else{
		$password=$_SESSION['pw'];
	}
	$servername = "localhost";
	$dbname = "library";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		logout();
		die("Connection failed: " .$conn->connect_error."<br><button onclick=\"goBack()\"> Return </button>");
	}

$errors = array();
?>