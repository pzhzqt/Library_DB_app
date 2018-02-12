<?php
	$studentid=get_student_id($username,$conn);
	$sql = $conn->prepare("select classid,course_title,textbook_title,ISBN from registration_info where studentid=?");
	$sql->bind_param('i',$studentid);
	$sql->execute();
	$result = $sql->get_result();
?>