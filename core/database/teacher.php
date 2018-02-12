<?php
	$teacherid=get_teacher_id($username,$conn);
	$sql = $conn->prepare("select classid,course_title,textbook_title,ISBN from teaching_info where teacherid=?");
	$sql->bind_param('i',$teacherid);
	$sql->execute();
	$result = $sql->get_result();
?>