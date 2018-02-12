<!DOCTYPE html>
<html>

<?php
include 'includes/head.php';
?>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

  <?php include 'includes/header.php'; ?>
  <!-- <section class="main"> to jest sekcja do rustic.js, gdybym chcial uruchomic-->
  
<section class="login">
	<div class="container">
<?php
	if (empty($_POST)===true){
		session_start();
		if(isset($_SESSION['un'])){
			header('Location: index.php');
		}else{
			include 'includes/login/login.php';
		}
	}else{
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		
		include 'core/init.php';
		
	/*	if (empty($username) === true||empty($password) === true){
			$errors[]='Need both username and password';
		}else if (user_exist($username,$usertype) === false){
			$errors[]="User not exist";
		}else if (match($username,$password,$usertype)===false){
			$errors[]="Password doesn't match username";
		}else{
			include $usertype.'.php';
		} */
		header("Location: index.php");
	}
?>
	</div>
</section>
<?php include 'includes/overall/footer.php';?>