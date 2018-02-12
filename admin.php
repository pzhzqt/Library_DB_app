<?php include 'includes/overall/header.php'?>
  <section id="admin">
    <div class="container">
	<?php
		if(get_user_type($username,$conn)!='admin'){
			die('You are not an admin');
		}
	?>
	 <form action="result.php"
		   method="post">
      <input type="submit" name="info" value="User Information">
      <input type="submit" name="info" value="Student Information">
	  <input type="submit" name="info" value="Course Information">
	  <input type="submit" name="info" value="Book Information">
	  <input type="submit" name="info" value="Checkout Information">
	 </form>
	<?php
		include 'section/checkout.php';
	?>
	</div>
  </section>

<?php include 'includes/overall/footer.php' ?>
