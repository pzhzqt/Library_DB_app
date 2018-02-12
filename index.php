<?php 
	include 'includes/overall/header.php';
	if(get_user_type($username,$conn)=='admin'){
		header('Location: admin.php');
	}else if(get_user_type($username,$conn)=='teacher'){
		header('Location: teacher.php');
	}else{
		header('Location: student.php');
	}
?>