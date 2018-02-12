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
	if (empty($_POST)==true){
		include 'includes/login/register.php';
	}else{
		$username='root';
		$password='';
		include 'core/init.php';
		$username=$_POST['username'];
		$password=$_POST['password'];
		$usertype=$_POST['usertype'];
		$id=$_POST['id'];
		$FName=$_POST['FName'];
		$LName=$_POST['LName'];
		if(empty($username)==true||empty($password)==true||empty($id)==true||empty($FName)==true||empty($LName)==true){
			$errors[]= "You need to fill in all the columns";
		}else if($password!=$_POST['repassword']){
			$errors[]= "Password doesn't match confirm_passwords";
		}else if(user_exist($username,$conn)==true){
			$errors[]= "Username already exists, choose another username";
		}else if(info_match($id,$FName,$LName,$usertype,$conn)==false){
			$errors[]= "Invalid user information. Registration denied";
		}else if(account_created($id,$usertype,$conn)==true){
			$errors[]= "An account has already been created for this user";
		}else{
			$password=md5($password);
			$result=create_user($id,$username,$password,$usertype,$conn);
			if ($result==true){
				logout();
				die("successfully created account<br><a style=\"color:black;text-decoration: underline;\" href=\"login.php\">Login</a>");
			}else{
				logout();
				echo "failed to create account";
			}
		}
		logout();
		foreach ($errors as $key=>$value){
			print_r($value);
		}
		echo "<br><button onclick=\"goBack()\"> Return </button>";
	}
?>
		</div>
</section>
<?php include 'includes/overall/footer.php'?>