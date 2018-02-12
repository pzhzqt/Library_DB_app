<!DOCTYPE html>
<html>

<?php include 'includes/overall/header.php'?>

<section id="student">
    <div class="container">
      <!-- Student table -->
	  <?php include 'core/database/student.php';?>
          <div class="tableheader">
              <h1></h1> STUDENT REGISTRATION INFORMATION
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