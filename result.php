<?php include 'includes/overall/header.php';?>
<?php
if (empty($_POST)===true){
	header("Location: index.php");
}else{
	include 'core/database/query.php';
}
?>
<section class="result">
    <div class="container">
        <!-- Student table -->
		<div class="tableheader">
			<h1>RESULT</h1>
		</div>
        <div class="tabledetals">
			<?php
				if($sql->error){
					die("Failed.".$sql->error."<br><button onclick=\"goBack()\"> Return </button>");
				}
				output($result);
			?>
			<br>
			<button onclick="goBack()"> Return </button>
        </div>
    </div>
</section>
<?php include 'includes/overall/footer.php'; ?>
