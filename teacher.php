<?php include 'includes/overall/header.php'?>

<section id="teacher">
    <div class="container">
	<?php
		if(get_user_type($username,$conn)!='teacher'){
			die('You are not a teacher');
		}else{
			include 'core/database/teacher.php';
		}
	?>
    <div class="tableheader">
        <h4> INSTRUCTOR INFORMATION</h1>
    </div>
        <div class="tabledetals">
			<?php
				if($sql->error){
					die("Failed.".$sql->error."<br><button onclick=\"goBack()\"> Return </button>");
				}
				output($result);
			?>
        </div>
    </div>
</section>

<?php include 'includes/overall/footer.php' ?>
